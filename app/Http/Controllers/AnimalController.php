<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnimalController extends Controller
{
    
    public function index(Request $request)
    {
        $animals = Animal::where("userId", auth()->user()->id)->get();
        return view("posts", compact("animals"));
    }

    
}