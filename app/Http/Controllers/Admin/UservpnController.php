<?php

namespace App\Http\Controllers\Admin;

use App\ClientDNS;
use App\ClientVPN;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportUserDNS;
use App\Exports\ExportUserVPN;
use Carbon\Carbon;
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
        Inertia::share('__token', csrf_token());
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
            '__index'   => 'admin.uservpn.index',
            '__export'  => 'admin.uservpn.excel'
        ]);
    }

    public function detail(Request $request, $ip)
    {
        $ip = str_replace('_', '.', $ip);
        $client = ClientVPN::where('ip_lokal', $ip)->first();
        return Inertia::render('Uservpn/detail', [
            'dataClient' => $client,
            'dataClientDnsAllowed' => ClientDNS::getData($ip, $request->input('search'), [2, 3])->paginate(10),
            'dataClientDnsBlocked' => ClientDNS::getData($ip, $request->input('search'), [1, 4])->paginate(10),
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
            '__export'  => 'admin.uservpn.detailexcel',
            '__back'   => 'admin.uservpn.index'
        ]);
    }

    public function export_excel(Request $request)
    {
        $current_timestamp = Carbon::now()->timestamp;
        $downloadname = $current_timestamp . "_dataUserVPN.xlsx";
        if ($request->input('search')) {
            $downloadname = $current_timestamp . "_dataUserVPN_" . $request->input('search') . ".xlsx";
        }
        return (new ExportUserVPN)->search($request->input('search'))->download($downloadname);
    }


    public function detailexport_excel(Request $request, $ip)
    {
        $current_timestamp = Carbon::now()->timestamp;
        $downloadname = $current_timestamp . "_detail_ip_$ip.xlsx";
        if ($request->input('search')) {
            $downloadname = $current_timestamp . "_detail_ip_$ip" . $request->input('search') . ".xlsx";
        }
        $ip = str_replace('_', '.', $ip);
        return (new ExportUserDNS)->clientIp($ip)->search($request->input('search'))->download($downloadname);
    }
}
