<?php

namespace App\Http\Controller;

use App\User;
use System\Str\Str;
use System\Cookie\Cookie;
use App\Http\Controller\Controller;
use System\Database\DBBuilder\DBBuilder;

class HomeController extends Controller
{
    public function index()
    {
        return view("welcome");
    }
}
