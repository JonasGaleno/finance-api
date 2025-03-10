<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class FinancialGoal extends Model
{
    use HasFactory;

    protected $table = 'financial_goals';
    protected $fillable = [
        'name',
        'user_id',
        'category_id',
        'target_amount',
        'current_amount',
        'deadline_date'
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
