<?php

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
class UserRole extends Model {
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public $table = 'user_role';

    protected $fillable = [
        'user_id','role_id'
    ];
}