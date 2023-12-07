<?php

namespace App\Http\Controllers;

use App\Models\App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = App::where('type', 'article')->orderBy('created_at', 'DESC')->get();
        return view('article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('article.create');
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
        $data['type'] = 'article';

        App::create($data);

        return redirect('/content/articles')->with('success', 'Artikel Ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(App $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(App $article)
    {
        return view('article.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, App $article)
    {
        $data = $request->validate([
            'title' => 'required|min:5',
            'description' => 'required|min:5',
            'image' => 'file|between:0,2048|mimes:jpeg,jpg,png',
        ]);

        if ($request['image']) {
            Storage::delete($article->image);
            $filetype = $request->file('image')->extension();
            $text = Str::random(16) . '.' . $filetype;
            $data['image'] = Storage::putFileAs('postImage', $request->file('image'), $text);
        }

        $article->update($data);

        return redirect('/content/articles')->with('success', 'Artikel Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(App $article)
    {
        Storage::delete($article->image);
        $article->delete();
        return redirect('/content/articles')->with('success', 'Artikel Dihapus');
    }
}
