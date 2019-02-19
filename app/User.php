<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Validator;

class User extends Authenticatable
{
    // use Notifiable
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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

    /**
     * @author : ### ###
     *
     * Method name: apiValidateRegister
     * Define for validate User pin.
     *
     * @param  {array} data - The data is array of User
     * @return  array object of validate User
     */
    public static function apiValidateRegister($data)
    {
        $rule = array(
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        );
        $messages = array(
            'required' => ':attribute field is required.',
            'email' => ':attribute is valid email address.',
        );
        $data = Validator::make($data, $rule, $messages);
        $data->setAttributeNames(array(
            'name' => ucfirst('name'),
            'email' => ucfirst('email'),
            'password' => ucfirst('password'),
        ));
        return $data;
    }

}
