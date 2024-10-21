<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    private $post;
    private $user;

    public function __construct(Post $post, User $user) {
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $all_posts = $this->post->latest()->get();
        // return view('users.home') // homepage
        // ->with('all_posts', $all_posts);
        $home_posts = $this->getHomePosts();
        $suggested_users = $this->getSuggestedUsers();
        return view('users.home')
        ->with('home_posts', $home_posts)
        ->with('suggested_users', $suggested_users);
    }

    /**
     * Filter the posts that will be displayed in the home page
     * Only the possts of the user that the Auth user if following should be displayed 
     */
    private function getHomePosts(){
        $all_posts = $this->post->latest()->get(); // Get all the posts from the posts table
        $home_posts = []; // Declare an empty array. In case the $home_posts is empty, it will not return NULL, but empty instead.

        foreach ($all_posts as $post) {
            if ($post->user->isFollowed() || $post->user->id === Auth::user()->id) { //This will return true if the AUTH user already following that user
                $home_posts[] = $post;
            }
        }
        return $home_posts;
    }

    /**
     * Get the list so f users that the Auth Use is nobt following yet
     */
    private function getSuggestedUsers() {
        $all_users = $this->user->all()->except(Auth::user()->id);
        $suggested_users = [];

        foreach ($all_users as $user) {
            if (! $user->isFollowed()) {
                $suggested_users[] = $user;
            }
        }

        // return $suggested_users; // This array contains the lists of users that are not yet being followed by the logged-in users.

        return array_slice($suggested_users, 0, 5);
        # array_slice(x, y, z)
        # array_slice(array, starting index, limit);
    }

    /**
     * Method to search user
     */
    public function search(Request $request){
        $users = $this->user->where('name', 'like', '%'. $request->search. '%')->get();
        /**
         * Users table
         * 
         * 1. John Smith
         * 2. John Doe
         * 3. Jane Marry
         * 4. John II Mcartney
         * 5. Tim John Davis
         * 
         * % works as a wild card, so if we search "John", 4 users will be retrieved.
         */
        return view('users.search')
        ->with('users', $users)
        ->with('search', $request->search);
    }

}
