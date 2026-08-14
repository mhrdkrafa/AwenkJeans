<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('brand_id')->nullable()->after('size_id')->constrained('brands')->onDelete('set null');
            $table->foreignId('model_id')->nullable()->after('brand_id')->constrained('product_models')->onDelete('set null');
            $table->foreignId('color_id')->nullable()->after('model_id')->constrained('colors')->onDelete('set null');
        });

        // Migrate existing text data into new master tables & link back
        $products = DB::table('products')->get();
        foreach ($products as $product) {
            $brandId = null;
            $modelId = null;
            $colorId = null;

            if (!empty($product->brand)) {
                $brandName = trim($product->brand);
                $brandSlug = Str::slug($brandName);
                $existingBrand = DB::table('brands')->where('name', $brandName)->first();
                if (!$existingBrand) {
                    $brandId = DB::table('brands')->insertGetId([
                        'name' => $brandName,
                        'slug' => $brandSlug ?: Str::random(6),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } else {
                    $brandId = $existingBrand->id;
                }
            }

            if (!empty($product->model)) {
                $modelName = trim($product->model);
                $existingModel = DB::table('product_models')
                    ->where('name', $modelName)
                    ->where('brand_id', $brandId)
                    ->first();
                if (!$existingModel) {
                    $modelId = DB::table('product_models')->insertGetId([
                        'brand_id' => $brandId,
                        'name' => $modelName,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } else {
                    $modelId = $existingModel->id;
                }
            }

            if (!empty($product->color)) {
                $colorName = trim($product->color);
                $existingColor = DB::table('colors')->where('name', $colorName)->first();
                if (!$existingColor) {
                    $colorId = DB::table('colors')->insertGetId([
                        'name' => $colorName,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } else {
                    $colorId = $existingColor->id;
                }
            }

            if ($brandId || $modelId || $colorId) {
                DB::table('products')->where('id', $product->id)->update([
                    'brand_id' => $brandId,
                    'model_id' => $modelId,
                    'color_id' => $colorId,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['brand_id']);
            $table->dropForeign(['model_id']);
            $table->dropForeign(['color_id']);
            $table->dropColumn(['brand_id', 'model_id', 'color_id']);
        });
    }
};
