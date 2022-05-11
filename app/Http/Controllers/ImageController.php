<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class ImageController extends Controller
{
    public function index() {
        return view('imgs.index', ['imgs' => Image::all()]);
    }

    public function upload(Request $request) {

        if($request->hasFile('avatar'))
        {
            $path = $request->file('avatar')->store('avatars');
            Image::create(['path'=>$path]);
        }

        return redirect()->route('imgs.index');
    }
}
