<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\User;
use App\Models\Color;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Ramsey\Uuid\Uuid;

class PostController extends Controller
{
    
    public function self(Request $request)
    {
        $animals = Animal::where("userId", auth()->user()->id)->get();
        return view("myposts", compact("animals"));
    }

    public function index(Animal $animal){
        $animal = Animal::where('uuid', $animal->uuid)->first();
        $user = User::where('id', $animal->userId)->first();
        $color = Color::where('id', $animal->colorId)->first();
        return view("about-animal", compact("animal", "user", "color"));
    }
    
    public function show(){
        $animals = Animal::all();
        $users = User::all();
        return view("posts", compact("animals", "users"));
    }
    public function showApi() {
        $animals = Animal::all(); 
        return $animals;
    }

    public function edit(Animal $animal) : View
    {
        $colors = Color::all();
        return view("editpost", compact('animal', 'colors'));
    }

    public function update(Request $request, Animal $animal) : RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string'],
            'chip' => ['nullable','string', 'max:16'],
            'gender' => ['required'],
            'color' => ['required'],
            'description' => ['required', 'string', 'max:1000'],
            'picture' => [
                'nullable',
                'image',
                'mimes:jpg,png,jpeg,svg',
                'max:2048'
            ],
        ]);

        
        $animal->name = $request->name;
        $animal->chipNumber = $request->chip;
        $animal->gender = $request->gender;
        $animal->colorId = $request->color;
        $animal->description = $request->description;

        if ($request->hasFile('picture')) {
            $imagePath = $request->file('picture')->store(
                'animal-pictures',
                'public'
            );
            $animal->image = $imagePath;
        }

        $animal->save();

        return Redirect::route('myposts.index')->with('status','animal-updated');
    }
    public function destroy(Animal $animal)
    {   
        $imagePath = $animal->image;
        //delete image
        unlink(public_path('storage/'.$imagePath));
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
        
                
        return Redirect::route('myposts.index')->with('status','animal-uploaded');
    }
}
