<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;
use App\Models\Size;
use App\Models\ProductView;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'size']);
        $search = $request->input('search');
        $category = $request->input('category');
        $size = $request->input('size');
        $brand = $request->input('brand');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $gender = $request->input('gender');
        $color = $request->input('color');

        // Search by name or brand
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('brand', 'like', '%' . $search . '%');
            });
        }

        if ($category) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->input('category'));
            });
        }

        if ($size) {
            $query->whereHas('size', function ($q) use ($request) {
                $q->where('name', $request->input('size'));
            });
        }

        if ($brand) {
            $query->where('brand', $brand);
        }

        if ($gender) {
            $query->where('gender', $gender);
        }

        if ($color) {
            $query->where('color', $color);
        }

        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }

        // Get all matching products, then group by name+category to merge size variants
        $allProducts = $query->get();

        $grouped = $allProducts->groupBy(function ($product) {
            return $product->name . '|' . $product->category_id;
        });

        // Build a collection of "representative" products (one per group) with aggregated data
        $groupedProducts = $grouped->map(function ($variants) {
            // Prefer the variant that has an image as representative
            $representative = $variants->firstWhere('image', '!=', null) ?? $variants->first();
            // Attach aggregated info as dynamic properties
            $representative->total_stock = $variants->sum('stock');
            $representative->available_sizes = $variants->filter(function ($v) {
                return $v->stock > 0;
            })->map(function ($v) {
                return $v->size->name ?? '-';
            })->unique()->sort()->values()->toArray();
            $representative->variant_count = $variants->count();
            $representative->min_stock_value = $variants->min('min_stock');
            // Ensure image is taken from any variant that has one
            if (!$representative->image) {
                $withImage = $variants->firstWhere('image', '!=', null);
                if ($withImage) {
                    $representative->image = $withImage->image;
                }
            }
            return $representative;
        })->values();

        // Manual pagination for grouped products
        $page = $request->input('page', 1);
        $perPage = 12;
        $total = $groupedProducts->count();
        $items = $groupedProducts->slice(($page - 1) * $perPage, $perPage)->values();
        $products = new \Illuminate\Pagination\LengthAwarePaginator(
            $items, $total, $perPage, $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $sizes = Size::all();
        $categories = Category::withCount('products')->get();
        $availableColors = Product::whereNotNull('color')->where('color', '!=', '')->distinct()->pluck('color')->sort()->values();
        $availableBrands = Product::whereNotNull('brand')->where('brand', '!=', '')->distinct()->pluck('brand')->sort()->values();

        // Featured Products (Latest 4, grouped)
        $featuredAll = Product::with(['category', 'size'])->latest()->get();
        $featuredProducts = $featuredAll->groupBy(function ($p) {
            return $p->name . '|' . $p->category_id;
        })->map(function ($variants) {
            $rep = $variants->firstWhere('image', '!=', null) ?? $variants->first();
            $rep->total_stock = $variants->sum('stock');
            $rep->available_sizes = $variants->filter(function ($v) {
                return $v->stock > 0;
            })->map(function ($v) {
                return $v->size->name ?? '-';
            })->unique()->sort()->values()->toArray();
            $rep->min_stock_value = $variants->min('min_stock');
            if (!$rep->image) {
                $withImage = $variants->firstWhere('image', '!=', null);
                if ($withImage) $rep->image = $withImage->image;
            }
            return $rep;
        })->values()->take(4);

        // Best Sellers (Most viewed, grouped - only show products with >= 25 views)
        $bestAll = Product::with(['category', 'size'])
            ->withCount('views')
            ->orderBy('views_count', 'desc')
            ->get();
        $bestSellers = $bestAll->groupBy(function ($p) {
            return $p->name . '|' . $p->category_id;
        })->map(function ($variants) {
            $rep = $variants->sortByDesc('views_count')->first();
            $rep->total_stock = $variants->sum('stock');
            $rep->views_count = $variants->sum('views_count');
            $rep->available_sizes = $variants->filter(function ($v) {
                return $v->stock > 0;
            })->map(function ($v) {
                return $v->size->name ?? '-';
            })->unique()->sort()->values()->toArray();
            $rep->min_stock_value = $variants->min('min_stock');
            if (!$rep->image) {
                $withImage = $variants->firstWhere('image', '!=', null);
                if ($withImage) $rep->image = $withImage->image;
            }
            return $rep;
        })->filter(function ($product) {
            return $product->views_count >= 25;
        })->sortByDesc('views_count')->values()->take(4);

        // Recent Reviews for Social Proof
        $recentReviews = \App\Models\Review::with(['user', 'product'])
            ->where('rating', '>=', 4)
            ->latest()
            ->take(3)
            ->get();

        // Track catalog page visit (anonymous - no login required)
        $this->trackVisit($request, null, 'catalog');

        return view('catalog.index', compact(
            'products', 
            'sizes', 
            'categories',
            'availableColors',
            'availableBrands',
            'featuredProducts', 
            'bestSellers', 
            'recentReviews'
        ));
    }

    /**
     * AJAX endpoint for live search autocomplete suggestions.
     */
    public function searchSuggestions(Request $request)
    {
        $search = $request->input('q', '');

        if (strlen($search) < 2) {
            return response()->json([]);
        }

        $products = Product::with('category')
            ->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('brand', 'like', '%' . $search . '%');
            })
            ->select('id', 'name', 'brand', 'slug', 'image', 'price', 'category_id')
            ->get()
            ->groupBy(function ($p) {
                return $p->name . '|' . $p->category_id;
            })
            ->map(function ($variants) {
                $rep = $variants->firstWhere('image', '!=', null) ?? $variants->first();
                return [
                    'name' => $rep->name,
                    'brand' => $rep->brand,
                    'slug' => $rep->slug,
                    'category' => $rep->category->name ?? '-',
                    'image' => $rep->image ? asset('storage/' . $rep->image) : null,
                    'price' => 'Rp ' . number_format($rep->price, 0, ',', '.'),
                ];
            })
            ->values()
            ->take(8);

        // Also get unique brand matches
        $brands = Product::where('brand', 'like', '%' . $search . '%')
            ->whereNotNull('brand')
            ->where('brand', '!=', '')
            ->distinct()
            ->pluck('brand')
            ->take(3)
            ->map(function ($brand) {
                return [
                    'type' => 'brand',
                    'name' => $brand,
                ];
            });

        return response()->json([
            'products' => $products,
            'brands' => $brands,
        ]);
    }

    public function show($slug)
    {
        $product = Product::with(['category', 'size'])->where('slug', $slug)->firstOrFail();

        // Fetch all reviews for all size variants of this product name
        $variantIds = Product::where('name', $product->name)
            ->where('category_id', $product->category_id)
            ->pluck('id');

        $reviews = \App\Models\Review::with(['user', 'product.size'])
            ->whereIn('product_id', $variantIds)
            ->latest()
            ->get();

        $product->setRelation('reviews', $reviews);

        // Related Products (Same category, excluding current product AND its size variants)
        $relatedAll = Product::with(['category', 'size'])
            ->where('category_id', $product->category_id)
            ->where('name', '!=', $product->name)
            ->get();
        
        // Group related products by name to avoid showing size variants as separate cards
        $relatedProducts = $relatedAll->groupBy(function ($p) {
            return $p->name . '|' . $p->category_id;
        })->map(function ($variants) {
            $rep = $variants->firstWhere('image', '!=', null) ?? $variants->first();
            $rep->total_stock = $variants->sum('stock');
            if (!$rep->image) {
                $withImage = $variants->firstWhere('image', '!=', null);
                if ($withImage) $rep->image = $withImage->image;
            }
            return $rep;
        })->values()->take(4);

        // Track product view (anonymous - no login required)
        $this->trackVisit(request(), $product->id, 'product');

        return view('catalog.show', compact('product', 'relatedProducts'));
    }

    /**
     * Track a visitor's page view.
     * Works for both anonymous visitors and logged-in users.
     * Uses IP + session to identify unique visitors without requiring login.
     */
    private function trackVisit(Request $request, ?int $productId, string $pageType): void
    {
        $visitorUuid = $request->cookie('visitor_uuid');

        if (!$visitorUuid) {
            $visitorUuid = (string) \Illuminate\Support\Str::uuid();
            \Illuminate\Support\Facades\Cookie::queue('visitor_uuid', $visitorUuid, 60 * 24 * 365 * 5); // 5 years
        }

        // Prevent reload spamming: only log unique views per visitor/product every 15 minutes
        $exists = ProductView::where('visitor_uuid', $visitorUuid)
            ->where('product_id', $productId)
            ->where('page_type', $pageType)
            ->where('created_at', '>=', now()->subMinutes(15))
            ->exists();

        if ($exists) {
            return;
        }

        $sessionId = session()->getId();
        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();
        $userId = Auth::id(); // null for anonymous visitors

        // Create a new view log entry for each unique visit
        ProductView::create([
            'user_id'      => $userId,
            'product_id'   => $productId,
            'session_id'   => $sessionId,
            'visitor_uuid' => $visitorUuid,
            'ip_address'   => $ipAddress,
            'user_agent'   => $userAgent,
            'page_type'    => $pageType,
            'view_count'   => 1,
        ]);
    }
}
