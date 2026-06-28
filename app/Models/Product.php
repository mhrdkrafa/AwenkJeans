<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'size_id',
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
