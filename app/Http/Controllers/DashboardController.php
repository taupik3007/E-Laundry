<?php

namespace App\Http\Controllers;
use App\Models\LaundryPackage;
use App\Models\LaundryService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function employeeDashboard(){
        $service = LaundryService::count();
        // dd($service);
        return view('employee.dashboard',compact(['service']));
    }
}
