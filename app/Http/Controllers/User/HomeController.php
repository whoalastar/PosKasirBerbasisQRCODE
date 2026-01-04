<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('user.welcome');
    }

    public function scanInstructions()
    {
        return view('user.scan-instructions');
    }
}
