<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

use Carbon\Carbon;

class ReportsController extends Controller
{

    private $post;
    private $user;

    public function __construct(Post $post, User $user){
        $this->post = $post;
        $this->user = $user;
    }

    public function index() {
        return view('admin.reports.reports');
    }

public function posts() {
    $all_posts = $this->post->latest()->get();

    $weeks_posts = $this->post->whereBetween('created_at', [
        Carbon::now()->startOfWeek(),
        Carbon::now()->endOfWeek()
    ])->get();
    
    $todays_posts = $this->post->whereDate('created_at', Carbon::today())->get();
    
    return view('admin.reports.posts')
        ->with('all_posts', $all_posts)
        ->with('weeks_posts', $weeks_posts)
        ->with('todays_posts', $todays_posts);
}

public function users() {
    $all_users = $this->user->latest()->get();

    $weeks_users = $this->user->whereBetween('created_at', [
        Carbon::now()->startOfWeek(),
        Carbon::now()->endOfWeek()
    ])->get();
    
    $todays_users = $this->user->whereDate('created_at', Carbon::today())->get();

    $popular_users = $this->user->withCount('followers')->orderBy('followers_count', 'desc')->limit(5)->get();


    $user_names = $popular_users->pluck('name'); // ユーザー名を取得
    $follower_counts = $popular_users->pluck('followers_count'); // フォロワー数を取得

    return view('admin.reports.users', compact('all_users', 'weeks_users','popular_users', 'todays_users', 'user_names', 'follower_counts'));
}

}
