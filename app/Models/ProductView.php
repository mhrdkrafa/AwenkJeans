<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductView extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'session_id',
        'ip_address',
        'user_agent',
        'page_type',
        'view_count',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the browser name from user agent string.
     */
    public function getBrowserAttribute(): string
    {
        $ua = $this->user_agent ?? '';

        if (str_contains($ua, 'Edg/')) return 'Edge';
        if (str_contains($ua, 'OPR/') || str_contains($ua, 'Opera')) return 'Opera';
        if (str_contains($ua, 'Chrome/') && !str_contains($ua, 'Edg/')) return 'Chrome';
        if (str_contains($ua, 'Firefox/')) return 'Firefox';
        if (str_contains($ua, 'Safari/') && !str_contains($ua, 'Chrome/')) return 'Safari';

        return 'Lainnya';
    }

    /**
     * Get the device type from user agent string.
     */
    public function getDeviceAttribute(): string
    {
        $ua = $this->user_agent ?? '';

        if (preg_match('/Mobile|Android.*Mobile|iPhone|iPod/i', $ua)) return 'Mobile';
        if (preg_match('/iPad|Android(?!.*Mobile)|Tablet/i', $ua)) return 'Tablet';

        return 'Desktop';
    }
}
