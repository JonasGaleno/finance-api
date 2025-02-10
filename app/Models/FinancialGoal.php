<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialGoal extends Model
{
    use HasFactory;

    protected $table = 'financial_goals';
    protected $fillable = [
        'user_id',
        'name',
        'target_amount',
        'current_amount',
        'category_id',
        'deadline_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
