<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * linstening
     */
     public static function boot(){
         parent::boot();

         static::creating(function($user){
             $user->activation_token = str_random(30);
         });
     }

    /**
     *get user's profile photo
     *
     * @param image Size
     *
     *@return profile photo url
     */
     public function gravatar($size = '100'){
         $hash = md5(strtolower(trim($this->attributes['email'])));
         return "http://www.gravatar.com/avatar/$hash?s=$size";
     }

     //user-statuses relationship
     public function statuses(){
         return $this->hasMany(Status::class);
     }

     //action of showing all statuses of followed users
     public function feed(){
         return $this->statuses()
                     ->orderBy('created_at', 'desc');
     }
}
