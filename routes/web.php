<?php

use Illuminate\Support\Facades\Route;

/**
 * Controller for admin users
 */
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\CategoriesController;

/**
 * Controller for regular users
 */
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;

Auth::routes();

/**
 * Auth -- Authentication
 * This group is protected by the middle ware(using protection called auth)
 */
Route::group(['middleware'=>'auth'], function(){
    Route::get('/', [HomeController::class, 'index'])->name('index'); //homepage

    Route::get('/people', [HomeController::class, 'search'])->name('search');
    

    Route::get('/post/create', [PostController::class, 'create'])->name('post.create');

    Route::post('/post/store', [PostController::class, 'store'])->name('post.store');

    Route::get('/post/{post_id}/show', [PostController::class, 'show'])->name('post.show');

    Route::get('/post/{post_id}/edit', [PostController::class, 'edit'])->name('post.edit');

    Route::patch('/post/{post_id}/update', [PostController::class, 'update'])->name('post.update');

    Route::delete('/post/{post_id}/delete',[PostController::class, 'destroy'])->name('post.delete');

    // Routes related to comments
    Route::post('/comment/{post_id}/store',[CommentController::class, 'store'])->name('comment.store');

    Route::delete('/comment/{comment_id}/destroy', [CommentController::class, 'destroy'])->name('comment.destroy');

    // Routes related to Users Profile
    Route::get('/profile/{user_id}/show', [ProfileController::class, 'show'])->name('profile.show');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/follow/{user_id}/followers', [ProfileController::class, 'followers'])->name('follow.followers');

    Route::get('/follow/{user_id}/following', [ProfileController::class, 'following'])->name('profile.following');

    // Routes related to Like/Unlike
    Route::post('/like/{post_id}/store', [LikeController::class, 'store'])->name('like.store');

    Route::delete('/like/{post_id}/destroy', [LikeController::class, 'destroy'])->name('like.destroy');

    // Routes related to Follow/Unfollow
    Route::post('/follow/{user_id}/store', [FollowController::class, 'store'])->name('follow.store');

    Route::delete('/follow/{user_id}/destroy', [FollowController::class, 'destroy'])->name('follow.destroy');

    /**
     * Routes related to admin users
     */

     Route::group(['prefix' => 'admin', 'as' =>'admin.', 'middleware' => 'admin'], function(){
        /**
         * Users dashborad routes
         */
        Route::get('/users', [UsersController::class, 'index'])->name('users');

        Route::delete('/{user_id}/deactivate', [UsersController::class, 'deactivate'])->name('users.deactivate');

        Route::patch('/{user_id}/activate', [UsersController::class, 'activate'])->name('users.activate');

        /**
         * Posts dashboard routes
         */
        Route::get('/posts', [PostsController::class, 'index'])->name('posts');

        Route::delete('/posts/{post_id}/hide', [PostsController::class, 'hide'])->name('posts.hide');

        Route::patch('/posts/{post_id}/unhide', [PostsController::class, 'unhide'])->name('posts.unhide');

        /**
         * Categories dashbord routes
         */
        Route::get('/categories', [CategoriesController::class, 'index'])->name('categories');

        Route::post('/categories/store', [CategoriesController::class, 'store'])->name('categories.store');

        Route::patch('/categories/{category_id}/update', [CategoriesController::class, 'update'])->name('categories.update');

        Route::delete('/categories/{category_id}/destroy', [CategoriesController::class, 'destroy'])->name('categories.destroy');
     });
    }

);


/**
 * What is middleware?
 * 
 * ---> Middleware is mechanism for inspecting and filtering the HTTP requst entering the application.
 *      Think of middleware as a layer of sevurity that examines the request going through the application.
 */

