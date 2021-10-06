<?php

namespace App\Http\Controllers;

use App\Http\Helpers\UserHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;

use Redirect;

class DashboardController extends Controller
{
    // public function __construct() {
    //     $this->middleware('auth');
    // }

    
    public function showDashboard() {
        if (!Auth::check()) {
            return Redirect::to('login');
        }
        
        if (Auth::user()->is_admin) {
            return $this->getAllUsersByAdmin();
        }
        return $this->getRefferedUsersByUser(Auth::user()->id);
    }

    public function getAllUsersByAdmin()
    {
        $users = User::whereNull('is_admin')->withCount('referrals')->simplePaginate(5);
        return view('admin-dashboard',compact('users'));
    }

    public function getRefferedUsersByUser($userId)
    {
        $users = User::where('referrer_id',$userId)->simplePaginate(5);
        $chartData = User::select(DB::raw("COUNT(*) as count"),DB::raw('date(created_at) as date'))
                        ->where('referrer_id',$userId)
                        ->where('created_at', '>', Carbon::today()->subDay(14))
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();
        $counts = $chartData->pluck('count');
        $dates = $chartData->pluck('date');
        
        return view('user-dashboard',compact('users'))
                ->with('counts',json_encode($counts,JSON_NUMERIC_CHECK))
                ->with('dates',json_encode($dates,JSON_NUMERIC_CHECK));
    }
}