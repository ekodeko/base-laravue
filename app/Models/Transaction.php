<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Transaction extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'date',
        'number',
        'type',
        'description',
        'amount',
        'account_id',
        'category_id',
        'contact_id'
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            $prefix = $transaction->type === 'income' ? 'INC' : 'EXP';
            $count = static::whereYear('date', now()->year)
                         ->whereMonth('date', now()->month)
                         ->count();
            $transaction->number = $prefix . '/' . now()->format('Ym') . '/' . str_pad($count + 1, 4, '0', STR_PAD_LEFT);
        });
    }
}
