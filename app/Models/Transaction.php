<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'invoice_number',
        'user_id',
        'pelanggan_id',
        'customer_name',
        'customer_phone',
        'total_price',
        'payment_method',
        'payment_status',
        'midtrans_order_id',
        'snap_token',
    ];

    /**
     * Kasir yang menangani transaksi.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Alias: Kasir yang menangani transaksi.
     */
    public function cashier()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Pelanggan yang melakukan transaksi (jika terdaftar).
     */
    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'pelanggan_id');
    }

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }
}
