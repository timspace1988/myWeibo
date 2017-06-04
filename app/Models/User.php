<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Auth;

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

     //show all statuses of account owner and followed users
     public function feed(){
         $user_ids = Auth::user()->followings->pluck('id')->toArray();
         array_push($user_ids, Auth::user()->id);
         return Status::whereIn('user_id', $user_ids)
                               ->with('user')
                               ->orderBy('created_at', 'desc');
     }

     //my followers (many-many relationship)
     public function followers(){
         return $this->belongsToMany(User::class, 'followings_followers', 'following_id', 'follower_id');
     }

     //my follings (many-many relationship)
     public function followings(){
         return $this->belongsToMany(User::class, 'followings_followers', 'follower_id', 'following_id');
     }

     //follow aU ser
     public function follow($user_ids){
         if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->sync($user_ids, false);
     }

     //unfollow a user
     public function unfollow($user_ids){
         if(!is_array($user_ids)){
             $user_ids = compact('user_ids');
         }
         $this->followings()->detach($user_ids);
     }

     //check if is currently following a user
     public function isFollowing($user_id){
         return $this->followings->contains($user_id);
     }
}
