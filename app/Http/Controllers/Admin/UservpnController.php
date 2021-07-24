<?php

namespace App\Http\Controllers\Admin;

use App\ClientDNS;
use App\ClientVPN;
use App\ClientVPNMongo;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class UservpnController extends Controller
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

    public function index(Request $request)
    {

        return Inertia::render('Uservpn', [
            'dataClients' => ClientVPN::getData($request->input('search'))->paginate(10),
            'perPage' => 10,
            'filters' => $request->all(),
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "admin.dashboard"
                ],
                [
                    'title'   => "User Vpn",
                    'active'  => true
                ]
            ),
            '__detail'  => 'admin.uservpn.detail',
            '__index'   => 'admin.uservpn.index'
        ]);
    }

    public function detail(Request $request, $ip)
    {
        $ip = str_replace('_', '.', $ip);
        $client = ClientVPN::where('virt_address', $ip)->first();
        return Inertia::render('Uservpn/detail', [
            'dataClient' => $client,
            'dataClientDns' => ClientDNS::getData($ip, $request->input('search'))->paginate(10),
            'perPage' => 10,
            'filters' => $request->all(),
            'breadcrumbItems' => array(
                [
                    'icon'    => "fa-home",
                    'title'   => "Dashboard",
                    'href'    => "admin.dashboard"
                ],
                [
                    'title'   => "User Vpn",
                    'href'    => "admin.uservpn.index"
                ],
                [
                    'title'   => $client->device_name,
                    'active'  => true
                ]
            ),
            '__index'   => 'admin.uservpn.detail',
            '__back'   => 'admin.uservpn.index'
        ]);
    }
}
