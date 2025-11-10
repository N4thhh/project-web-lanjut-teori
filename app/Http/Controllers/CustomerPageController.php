<?php

namespace App\Http\Controllers;

use App\Models\LaundryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerPageController extends Controller
{
    public function dashboard()
    {
        return view('customer.dashboard', ['activeMenu' => 'dashboard']);
    }

    public function layanan()
    {
        $layanan = LaundryService::all();
        
        return view('customer.layanan', [
            'services' => $layanan,
            'activeMenu' => 'layanan'
        ]);
    }
}