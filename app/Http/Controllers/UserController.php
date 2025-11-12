<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Menampilkan halaman beranda customer.
     */
    public function index()
    {
        // View yang dikembalikan: resources/views/user/home.blade.php
        return view('user.home'); 
    }
}