<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class ProfileController extends Controller
{
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function show($user_id) {
        $user=$this->user->findOrFail($user_id);
        return view('users.profile.show')
        ->with('user', $user);
    }

    public function edit() {
        $user=$this->user->findOrFail(Auth::user()->id);
        return view('users.profile.edit')
        ->with('user', $user);
    }

    public function update(Request $request) {
        $request->validate([
            'avatar' => 'nullable|mimes:jpeg,jpg,png,gif|max:1048',
            'name' => 'required|min:1|max:255',
            'email' => 'required|email|max:255',
            'introduction' => 'nullable|min:0|max:255'
        ]);

        $user = $this->user->findOrFail(Auth::user()->id);
        if ($request->avatar) {          
                $user->avatar = 'data:avatar/'. $request->avatar->extension(). ';base64,'. base64_encode(file_get_contents($request->avatar));
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->introduction = $request->introduction;
        $user->save();

        return redirect()->route('profile.show', Auth::user()->id);
    }

    /**
     * Method to get the user details
     */
     public function followers($user_id) {
        $user=$this->user->findOrFail($user_id);
        return view('users.profile.followers')
        ->with('user', $user);
     }

     /**
      * Method use to get all the users that the user is following
      */
     public function following($user_id) {
        $user=$this->user->findOrFail($user_id);
        return view('users.profile.following')
        ->with('user', $user);
     }

     public function password() {
        $user=$this->user->findOrFail(Auth::user()->id);
        return view('users.profile.password')
        ->with('user', $user);
     }

     public function passwordValidate(Request $request) {
        $request->validate([
            'current_pass' => 'required'
        ]);
    
        $isValid = Hash::check($request->current_pass, Auth::user()->password);
    
        if ($isValid) {
            return redirect()->route('profile.password')->with('valid', true);
        } else {
            return redirect()->route('profile.password')->with('error', 'Wrong Password.');
        }
    }
    
    public function updatePassword(Request $request) {
        $request->validate([
            'new_pass' => 'required|min:6',
            'new_pass_check' => 'required|min:6'
        ]);

        if ($request->new_pass === $request->new_pass_check) {
            $user = Auth::user(); 
            $user->password = bcrypt($request->new_pass);
            $user->save(); 
            
            return redirect()->route('index')->with('status', 'Password Updated');
        } else {
            return redirect()->route('profile.password')->with('confirm_error', 'Input the same password. Please try it again.');
        }
    
    }
    

}
