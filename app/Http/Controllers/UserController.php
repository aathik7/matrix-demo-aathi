<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function profile()
    {
        if (Auth::check()) {
            $userDetails = User::where('id', Auth::user()->id)->first(['id', 'name', 'email']);
            return view('profile', ['userDetails' => !empty($userDetails) ? $userDetails->toArray() : []]);
        }
        return redirect("login")->withSuccess('Opps! You do not have access');
    }
}
