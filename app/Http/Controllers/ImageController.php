<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

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

    public function edit($imgId) {
        return view('imgs.edit', ['img' => Image::find($imgId)]);
    }

    public function update(Request $request, Image $img) {
        if($request->hasFile('avatar'))
        {
            Storage::delete("$img->path");
            $path = $request->file('avatar')->store('avatars');
            Image::find($img->id)->update(['path'=>$path]);
        }

        return redirect()->route('imgs.index');
    }
}
