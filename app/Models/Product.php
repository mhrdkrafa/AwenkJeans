<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'size_id',
        'brand_id',
        'model_id',
        'color_id',
        'name',
        'slug',
        'brand',
        'model',
        'price',
        'stock',
        'min_stock',
        'description',
        'image',
        'gender',
        'color',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function brandRelation()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function modelRelation()
    {
        return $this->belongsTo(ProductModel::class, 'model_id');
    }

    public function colorRelation()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function views()
    {
        return $this->hasMany(ProductView::class);
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }
}
