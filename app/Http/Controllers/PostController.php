<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Color;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Ramsey\Uuid\Uuid;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $animals = Animal::where("userId", auth()->user()->id)->get();
        return view("myposts", compact("animals"));
    }
    public function show(){
        $animals = Animal::all();
        return view("posts", compact("animals"));
    }
    public function showApi() {
        $animals = Animal::all(); 
        return $animals;
    }

    public function destroy(Animal $animal)
    {   
        $animal->delete();
        return Redirect::route('myposts.index')->with('status','animal-deleted');
    }
    public function create() : View
    {
        $colors = Color::all();

        return view("createpost", compact('colors'));
    }

    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string'],
            'chip' => ['nullable','string', 'max:16'],
            'gender' => ['required'],
            'color' => ['required'],
            'description' => ['required', 'string', 'max:1000'],
            'picture' => [
                'required',
                'image',
                'mimes:jpg,png,jpeg,svg',
                'max:2048'
            ],
        ]);

        $imagePath = $request->file('picture')->store(
            'animal-pictures',
            'public'
        );


        Animal::create([
            'uuid' => Uuid::uuid4()->toString(),
            'userId' => $request->user()->id,
            'name'=> $request->name,
            'chipNumber' => $request->chip,
            'gender' => $request->gender,
            'colorId' => $request->color,
            'description' => $request->description,
            'image' => $imagePath,
        ]);
        
                
        return Redirect::route('createpost')->with('status','animal-uploaded');
    }
}
