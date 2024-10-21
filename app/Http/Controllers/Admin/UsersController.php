<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function index() {
        /**
         * The withTrash() -> will include the soft deleted users records in the query result
         */
        $all_users = $this->user->withTrashed()->latest()->paginate(4);
        return view('admin.users.index')->with('all_users',$all_users);
    }



    public function deactivate($user_id) {
        $this->user->destroy($user_id);
        return redirect()->back();
    }

    /**
     * Method to restore the soft deleted users
     */
    public function activate($user_id) {
        $this->user->onlyTrashed()->findOrFail($user_id)->restore();
        /**
         * The onlyTrashed --> retrieces soft delete records only
         * restore() -->This will un-delete a soft deleted model/record. THis will set the "deleted_at" column to null
         */
        return redirect()->back();
    }
}
