<?php

namespace App\Http\Controllers;

use App\Models\Installation;
use App\Models\Invoice;
use App\Models\User;
use App\Models\UserMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalClient = User::where('role', 'user')->count();
        $totalInvoice = Invoice::where('status', 'Lunas')->sum('price');
        $totalInstallation = Installation::where('status', 'Antrian')->count();
        $invoicePending = Invoice::where('status', 'Proses')->orderBy('updated_at', 'DESC')->get();

        $data_request = Http::get('https://ibnux.github.io/data-indonesia/kecamatan/3511.json');

        if ($data_request->successful()) {
            $districts = $data_request->json();

            $clientDistrict = [];

            foreach ($districts as $district) {
                $meta = UserMeta::where('district_id', $district['id'])->count();

                $clientDistrict[] = [
                    'name' => $district['nama'],
                    'total' => $meta,
                ];
            }
        }


        return view('dashboard.index', compact('totalClient', 'totalInvoice', 'totalInstallation', 'invoicePending', 'clientDistrict', 'districts'));
    }
}
