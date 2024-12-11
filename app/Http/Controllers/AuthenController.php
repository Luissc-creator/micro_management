<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
//use Illuminate\Support\Facades\Auth;

class AuthenController extends Controller
{
    ////Registration
    public  function  registration()
    {
        return  view('auth.registration');
    }
    public  function  registerUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email:users',
            'password' => 'required|min:8 |max:12'
        ]);

        $userExists = User::where('email', $request->email)->exists();

        if ($userExists) {
            return back()->with('fail', 'Email already exists.');
        }

        $user = new  User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;


        $result = $user->save();
        if ($result) {
            return  redirect('view/login');
        } else {
            return  back()->with('fail', 'Something wrong!');
        }
    }
    ////Login
    public  function  showLoginForm($userType)
    {
        return  view('auth.login', ['userType' => $userType]);
    }

    public  function  login(Request $request)
    {
        $request->validate([
            'email' => 'required|email:users',
            'password' => 'required|min:3|max:20'
        ]);
        $user = User::where('email', $request->email)->first();
        session(['authenticated' => false]);
        if ($user) {
            if ($user->role !== $request->userType) {
                return back()->with('fail', 'You can not login as a ' . $request->userType);
            }
            if (Hash::check($request->password, $user->password)) {
                session(['userId' =>  $user->id]);
                if ($user->role === 'operator') {
                    session(['operator_id' => $user->operator->id, 'role' => 'operator', 'authenticated' => true]);
                    return redirect('operator/dashboard');
                } else if ($user->role === 'client') {
                    session(['client_id' => $user->client->id, 'role' => 'client', 'authenticated' => true]);
                    return redirect('/client/0/area');
                } else if ($user->role === 'admin') {
                    session(['user_id' => $user->id, 'role' => 'admin', 'authenticated' => true]);
                    return  redirect('view/admin/dashboard');
                }
            } else {
                return  back()->with('fail', 'Password not match!');
            }
        } else {
            return  back()->with('fail', 'This email is not registered.');
        }
    }
    //// Dashboard
    public  function  dashboard()
    {
        // return "Welcome to your dashabord.";
        $data = array();
        if (Session::has('loginId ')) {
            $data = User::where('id', '=', Session::get('loginId'))->first();
        }
        return  view('dashboard', compact('data'));
    }
    ///Logout
    public  function  logout()
    {
        session()->flush();
        return  redirect()->route('homepage');
    }
}
