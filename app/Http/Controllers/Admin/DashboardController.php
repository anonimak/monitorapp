<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Inertia\Inertia;
use App\ClientDNS;
use App\ClientVPN;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        Inertia::share('userinfo', User::get()->first());
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        // Synchronously
        return Inertia::render('Dashboard', [
            'userTotal' => ClientVPN::count(),
            'userOnline' => ClientVPN::where('online_status', 1)->count(),
            'topUserAgent' => ClientVPN::select(DB::raw("count(platform) total_platform, platform"))->groupBy('platform')->orderByDesc('total_platform')->limit(10)->get(),
            'topDomainAllowed' => ClientDNS::getTopDomain([2, 3], 10),
            'topDomainBlocked' => ClientDNS::getTopDomain([1, 4], 10),
            'meta' => [
                'title' => 'tests',
                'foo' => 'bar'
            ]
        ]);
    }
}
