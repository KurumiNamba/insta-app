<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    # A post belongs to a  user
    # use this method to get the owner of the post
    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }

    # Use this method to get the categories under a post
    public function categoryPost(){
        return $this->hasMany(CategoryPost::class);
    }

     /**
      * Use this method to get al the comments of a post
      */
      public function comments(){
        return $this->hasMany(Comment::class);
      }

      /**
       * Use this method to get the likes of a post
       */
      public function likes(){
        return $this->hasMany(Like::class);
      }

      /**
       * Return TRUE if the AUTH USER already like the post
       */
      public function isLiked(){
        return $this->likes()->where('user_id', Auth::user()->id)->exists();
      }

      public function likedByUsers () {
        return $this->belongsToMany(User::class, 'likes', 'post_id', 'user_id');
      }

}
