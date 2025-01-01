<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use PhpParser\Builder;
use Filament\Support\Contracts\HasLabel;
use Finance_system\App\Enums\BillSatus;

class bills extends Model
{

    protected $fillable = [
        'user_id',
        'transactions_id',
        'name',
        'amount',
        'frequency',
        'description'
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function transaction():HasMany
    {
        return $this->hasMany(transaction::class);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->user);
    }

    protected $casts = [
        'status' =>BillSatus::class
    ];   


}
