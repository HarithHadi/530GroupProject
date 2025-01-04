<?php

namespace App\Models;

use App\Enums\Transactionstate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class transaction extends Model
{

    protected $fillable = [
        'user_id',
        'category_id',
        'amount',
        'transaction_date',
        'description',
    ];
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function bills(): BelongsTo{
        return $this->belongsTo(bills::class);
    }
    public function category(): BelongsTo{
        return $this->belongsTo(category::class);
    }

    public function scopeForUser($query)
    {
        return $query->where('user_id',auth()->id());
    }

    protected $casts = [
        'category' =>Transactionstate::class
    ];
}
