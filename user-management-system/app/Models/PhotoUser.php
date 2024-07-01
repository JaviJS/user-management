<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PhotoUser extends Model
{
    use HasFactory;
    protected $table = 'photo_user';
    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'url',
        'extension',
        'original_name',
        'user_id'
    ];

    /**
     * Get the user that owns the photo_user.
     */
    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }
}
