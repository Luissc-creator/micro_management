<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;

class PageController extends Controller
{
    //
    function index()
    {
        return view('index');
    }

    function login()
    {
        return view('login');
    }

    function operatorArea()
    {
        return view('operator/area');
    }

    function operatorDashboard()
    {
        return view('operator/dashboard');
    }

    function clientDashboard()
    {
        return view('client/dashboard');
    }

    function adminDashboard()
    {
        return view('admin/dashboard');
    }
}
