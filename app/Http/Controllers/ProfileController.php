<?php

namespace App\Http\Controllers;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function myRents()
    {
        return view('profile.rents');
    }
}
