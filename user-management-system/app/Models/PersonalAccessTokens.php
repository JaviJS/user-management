<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalAccessTokens extends Model
{
    protected $table = 'personal_access_tokens';
    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'tokenable_type',
        'tokenable_id',
        'name',
        'token',
        'abilities',
        'last_used_at',
        'expires_at'
    ];

    protected $casts = [
        'last_used_at' => 'datetime',
    ];

    public function tokenable()
    {
        return $this->morphTo();
    }
}