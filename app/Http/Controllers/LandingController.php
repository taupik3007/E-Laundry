<?php

namespace App\Http\Controllers;

use App\Models\LaundryService;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $services = LaundryService::with('packages')->get();// ambil layanan
        return view('landing', compact('services'));
    }
}
