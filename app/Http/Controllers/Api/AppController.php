<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\App;
use Illuminate\Http\Request;

class AppController extends Controller
{
    function promo(Request $request)
    {
        $data = App::where('type', 'promo')->get();
        return ResponseFormatter::success($data);
    }

    function about(Request $request)
    {
        $data = App::where('type', 'about')->first();
        return ResponseFormatter::success($data);
    }

    function article(Request $request)
    {
        $data = App::where('type', 'berita')->get();
        return ResponseFormatter::success($data);
    }
}
