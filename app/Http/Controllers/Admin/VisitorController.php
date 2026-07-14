<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductView;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitorController extends Controller
{
    public function index(Request $request)
    {
        // Date filter
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $pageType = $request->input('page_type');

        $query = ProductView::with(['product'])->latest();

        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }
        if ($pageType && $pageType !== 'all') {
            $query->where('page_type', $pageType);
        }

        $views = $query->paginate(5)->withQueryString();

        // Summary stats
        $totalViews = ProductView::count();
        $todayViews = ProductView::whereDate('created_at', today())->count();
        $uniqueVisitors = DB::table('product_views')->distinct()->count(DB::raw('COALESCE(visitor_uuid, ip_address)'));
        $uniqueProducts = ProductView::whereNotNull('product_id')->distinct('product_id')->count('product_id');

        // Weekly visitor chart data (last 7 days)
        $weeklyData = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $count = ProductView::whereDate('created_at', $date->toDateString())->count();
            $uniqueCount = DB::table('product_views')
                ->whereDate('created_at', $date->toDateString())
                ->distinct()
                ->count(DB::raw('COALESCE(visitor_uuid, ip_address)'));
            $weeklyData->push([
                'label' => $date->translatedFormat('D'),
                'full_label' => $date->translatedFormat('d M'),
                'total' => $count,
                'unique' => $uniqueCount,
            ]);
        }

        // Top viewed products
        $topProducts = ProductView::whereNotNull('product_id')
            ->select('product_id', DB::raw('COUNT(*) as total_views'), DB::raw('COUNT(DISTINCT COALESCE(visitor_uuid, ip_address)) as unique_views'))
            ->groupBy('product_id')
            ->orderByDesc('total_views')
            ->with('product')
            ->take(5)
            ->get();

        // Device breakdown
        $allViews = ProductView::whereNotNull('user_agent')->get();
        $deviceStats = [
            'Desktop' => 0,
            'Mobile'  => 0,
            'Tablet'  => 0,
        ];
        foreach ($allViews as $v) {
            $device = $v->device;
            if (isset($deviceStats[$device])) {
                $deviceStats[$device]++;
            }
        }

        // Browser breakdown
        $browserStats = [];
        foreach ($allViews as $v) {
            $browser = $v->browser;
            $browserStats[$browser] = ($browserStats[$browser] ?? 0) + 1;
        }
        arsort($browserStats);

        return view('karyawan.visitors.index', compact(
            'views', 'totalViews', 'todayViews', 'uniqueVisitors', 'uniqueProducts',
            'weeklyData', 'topProducts', 'deviceStats', 'browserStats',
            'dateFrom', 'dateTo', 'pageType'
        ));
    }
}
