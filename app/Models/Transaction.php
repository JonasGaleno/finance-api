<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';
    protected $fillable = [
        'user_id',
        'description',
        'amount',
        'type',
        'category_id',
        'payment_method_id',
        'transaction_date'
    ];
    protected $hidden = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    protected static function booted()
    {
        static::saved(function () {
            Cache::flush();
        });

        static::deleted(function () {
            Cache::flush();
        });
    }
}
