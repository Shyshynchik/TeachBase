<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin Builder
 * @property mixed $id
 * @property mixed $email
 * @property mixed $name
 * @property mixed|string $token
 * @property mixed|string $refresh_token
 */
class User extends Eloquent {

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'token', 'refresh_token'
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }
}