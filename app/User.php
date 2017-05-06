<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Cartalyst\Sentinel\Users\EloquentUser as SentinelUser;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'short_name',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', '_token',
    ];

    public static $register_rule = [
      'first_name' => 'required',
      'last_name' => 'required',
      'short_name' => 'required|min:3|max:3|unique:users|alpha',
      'password' =>  'required|min:6|max:13|confirmed',
    ];
    public static $login_rules =[
      'short_name' => 'required|min:3|max:3|alpha',
      'password' =>  'required',

    ];
}
