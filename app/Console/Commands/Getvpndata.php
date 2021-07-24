<?php

namespace App\Console\Commands;

use App\ClientDNS;
use App\ClientVPN;
use App\ClientVPNMongo;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Getvpndata extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vpndata:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run cron get data VPN';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // update all to offline
        $this->info('vpndata:Cron update all to offline');
        ClientVPN::where('online_status', 1)->update(['online_status' => 0]);
        $clients = ClientVPNMongo::all();
        $this->info('vpndata:Cron run query ClientVPNMongo::all()');
        $clients->each(function ($client) {
            $cl = collect();
            $checkclient = ClientVPN::where('user_id', $client->user_id)->first();
            if ($checkclient) {
                // do update client info
                $checkclient->device_name = $client->device_name;
                $checkclient->type = $client->type;
                $checkclient->mac_addr = $client->mac_addr;
                $checkclient->virt_address = explode('/', $client->virt_address)[0];
                $checkclient->virt_address6 = $client->virt_address6;
                $checkclient->network = $client->network;
                $checkclient->real_address = $client->real_address;
                $checkclient->online_status = true;
                $checkclient->save();
                $this->info("vpndata:Cron update client info, id:$checkclient->user_id");
                $cl = $checkclient;
            } else {
                // insert new client
                $clientvpn = new ClientVPN;
                $clientvpn->user_id = $client->user_id;
                $clientvpn->device_name = $client->device_name;
                $clientvpn->type = $client->type;
                $clientvpn->mac_addr = $client->mac_addr;
                $clientvpn->virt_address = explode('/', $client->virt_address)[0];
                $clientvpn->virt_address6 = $client->virt_address6;
                $clientvpn->network = $client->network;
                $clientvpn->real_address = $client->real_address;
                $clientvpn->save();
                $this->info("vpndata:Cron insert new client id:$clientvpn->user_id");
                $cl = $clientvpn;
            }
            $virt_address = explode('/', $client->virt_address)[0];
            $requesttime = Carbon::now()->subMinute()->timestamp;
            // get dns browsing by local ip
            $this->info("vpndata:get dns data by local ip:$virt_address");
            $response = Http::get('http://122.248.231.68/admin/api.php', [
                'getAllQueries' => true,
                'auth' => '8a659b721003c6f5f468ae89ca95a70359d3d94ebeb1610f9af00ebfc6530096',
                'client' => $virt_address
            ]);
            // taruhke collection
            collect($response['data'])->filter(function ($item) use ($requesttime, $cl) {
                if ($item[0] >= $requesttime) {
                    // dd($item);
                    if (ClientDNS::where('timestamp', $item[0])->doesntExist()) {
                        // insert clientdns
                        $this->info("vpndata:insert dns data timestamp:$item[0]");
                        $clientdns = new ClientDNS;
                        $clientdns->user_id = $cl->user_id;
                        $clientdns->timestamp = $item[0];
                        $clientdns->type_ip = $item[1];
                        $clientdns->domain_name = $item[2];
                        $clientdns->client_ip = $item[3];
                        $clientdns->type = $item[4];
                        $clientdns->save();
                    }
                }
            });
        });

        $this->info('vpndata:Cron Cummand Run successfully!');
    }
}
