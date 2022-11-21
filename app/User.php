<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
/**
 * @OA\Schema (
 *     title="User",
 *     description="Users model",
 *     schema="User"
 * )
 */
class User extends Authenticatable
{
    /**
     * @OA\Schema (
     *     title="User",
     *     description="User model",
     *     type="object",
     *     schema="User",
     *     properties={
            @OA\Property(property="name",type="string"),
            @OA\Property(property="email",type="string"),
            @OA\Property(property="password",type="string"),
*     },
     *     required={"name","email","password"}
     * )
     */
    use Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','c_id','last_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
