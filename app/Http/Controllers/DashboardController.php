<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Dashboard;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index(){
        $user = auth()->user();
        if($user){
            $totalOrders = $user->orders()->count();
            $completedOrders = $user->orders()->where('status', 'paid')->count();
            $pendingOrders = $user->orders()->where('status', 'pending')->count();
            $canceledOrders = $user->orders()->where('status', 'canceled')->count();
            return view('app.profile.index' , compact([
                 'totalOrders' ,
                 'completedOrders' ,
                 'pendingOrders' ,
                 'canceledOrders'
                ]));
        }
    }

}
