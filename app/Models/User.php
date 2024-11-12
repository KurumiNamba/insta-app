<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    const ADMIN_ROLE_ID = 1; // Admin
    const USER_ROLE_ID = 2;  //Regular user

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Use this method to get all the posts of a user
     */
    public function posts() {
        return $this->hasMany(Post::class)->latest();
    }

    /**
     * Use this method to get all the followers of a user
     */
    public function followers(){
        return $this->hasMany(Follow::class, 'following_id');
    }

    /**
      * Use this method to get all the users that the user is following
      */
      public function following(){
        return $this->hasMany(Follow::class, 'follower_id');
      }

      /**
       * Method to use in checking if the user is already following a user
       */
      public function isFollowed(){
        return $this->followers()->where('follower_id', Auth::user()->id)->exists();
        // Auth::user()->id --> is always the follower
        // Firstly, get all the followers of the user ($this->followers()).
        // Then, from that list, search for the Auth user id from the follower column (where ('followe_id', Auth::user()->id))
      }

      public function isFollowing(){
        return $this->following()->where('following_id', Auth::user()->id)->exists();
      }

      public function followerNum() {
        $num = $this->followers()->count();
        if ($num==1) {
          return $num. ' follower';
        } elseif($num==0) {
          return 'No Follower yet';
        } else {
          return $num. ' followers';
        }
      }



      public function likedPosts() {
        return $this->belongsToMany(Post::class, 'likes', 'user_id', 'post_id', );
      }
}
