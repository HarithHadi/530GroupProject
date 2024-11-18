<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class category extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'user_id'
    ];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function transaction():HasMany
    {
        return $this->hasMany(transaction::class);
    }

    protected static function booted()
    {
        static::creating(function ($category){
            if(!$category->user_id){
                $category->user_id=null;
            }
        });     
    }
}
