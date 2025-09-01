<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $fillable = ['name', 'type', 'province_id', 'phone', 'logo_path'];

    protected $hidden = ['remember_token'];
    protected $casts = [
        'phone_verified_at' => 'datetime',
    ];
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

}
