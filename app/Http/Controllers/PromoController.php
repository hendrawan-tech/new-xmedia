<?php

namespace App\Http\Controllers;

use App\Models\App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = App::where('type', 'promo')->orderBy('created_at', 'DESC')->get();
        return view('promo.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('promo.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|min:5',
            'description' => 'required|min:5',
            'image' => 'required|file|between:0,2048|mimes:jpeg,jpg,png',
        ]);

        $filetype = $request->file('image')->extension();
        $text = Str::random(16) . '.' . $filetype;
        $data['image'] = Storage::putFileAs('postImage', $request->file('image'), $text);
        $data['type'] = 'promo';

        App::create($data);

        return redirect('/content/promos')->with('success', 'Promo Ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(App $promo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(App $promo)
    {
        return view('promo.edit', compact('promo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, App $promo)
    {
        $data = $request->validate([
            'title' => 'required|min:5',
            'description' => 'required|min:5',
            'image' => 'file|between:0,2048|mimes:jpeg,jpg,png',
        ]);

        if ($request['image']) {
            Storage::delete($promo->image);
            $filetype = $request->file('image')->extension();
            $text = Str::random(16) . '.' . $filetype;
            $data['image'] = Storage::putFileAs('postImage', $request->file('image'), $text);
        }

        $promo->update($data);

        return redirect('/content/promos')->with('success', 'Promo Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(App $promo)
    {
        Storage::delete($promo->image);
        $promo->delete();
        return redirect('/content/promos')->with('success', 'Promo Dihapus');
    }
}
