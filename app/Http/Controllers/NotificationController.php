<?php

namespace App\Http\Controllers;

use App\Models\App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = App::where('type', 'notif')->orderBy('created_at', 'DESC')->get();
        return view('notification.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('notification.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|min:5',
            'description' => 'required|min:5',
        ]);

        $data['type'] = 'notif';

        App::create($data);

        return redirect('/content/notifications')->with('success', 'Notifikasi Ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(App $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(App $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, App $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(App $notification)
    {
        $notification->delete();
        return redirect('/content/notifications')->with('success', 'Notifikasi Dihapus');
    }
}
