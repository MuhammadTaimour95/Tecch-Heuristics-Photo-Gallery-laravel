<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Album;

class AlbumsController extends Controller
{
    public function index()
    {
        $albums = Album::with('Photos')->get();

        return view('albums.index')->with('albums', $albums);
    }

    public function create()
    {
        return view('albums.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'cover_image' => 'image|max:1999'
        ]);

        // Get filename with extention
        $filenameWithExt =  $request->file('cover_image')->getClientOriginalName();

        //Get Just the file name 
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        //Get Extention
        $extention = $request->file('cover_image')->getClientOriginalExtension();

        // Create new file name

        $filenameToStore = $filename . '_' . time() . '.' . $extention;

        // Upload image

        $path = $request->file('cover_image')->storeAs('public/album_covers', $filenameToStore);

        //create album

        $album = new Album;
        $album->name = $request->input('name');
        $album->description = $request->input('description');
        $album->cover_image = $filenameToStore;

        $album->save();

        return redirect('/albums')->with('success', 'Album created');
    }

    public function show($id)
    {
        $album = Album::with('Photos')->find($id);
        return view('albums.show')->with('album', $album);
    }
}
