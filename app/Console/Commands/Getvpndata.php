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
            $checkclient = ClientVPN::where('id_user', $client->user_id)->first();
            if ($checkclient) {
                // do update client info
                $checkclient->online_status = true;
                $checkclient->mac_addr = $client->mac_addr;
                $checkclient->sistem_operasi = ($client->platform == 'win') ? 'windows' : $client->platform;
                $checkclient->ip_lokal = explode('/', $client->virt_address)[0];
                $checkclient->ip_publik = $client->real_address;
                $checkclient->save();
                $this->info("vpndata:Cron update client info, id:$checkclient->id_user");
                $cl = $checkclient;
            } else {
                // insert new client
                $clientvpn = new ClientVPN;
                $clientvpn->id_user = $client->user_id;
                $clientvpn->mac_addr = $client->mac_addr;
                $clientvpn->ip_lokal = explode('/', $client->virt_address)[0];
                $clientvpn->sistem_operasi = ($client->platform == 'win') ? 'windows' : $client->platform;
                $clientvpn->ip_publik = $client->real_address;
                $clientvpn->save();
                $this->info("vpndata:Cron insert new client id:$clientvpn->id_user");
                $cl = $clientvpn;
            }
            $ip_lokal = explode('/', $client->virt_address)[0];
            $requesttime = Carbon::now()->subMinute()->timestamp;
            // get dns browsing by local ip
            $this->info("vpndata:get dns data by local ip:$ip_lokal");
            $response = Http::get('http://52.221.239.78:1002/admin/api.php', [
                'getAllQueries' => true,
                'auth' => 'ea2bd3ab578e65f661c8ae2d210de73c129b5aa6dbef88297e1ccd419ba78346',
                'client' => $ip_lokal
            ]);
            // taruhke collection
            collect($response['data'])->filter(function ($item) use ($requesttime, $cl) {
                if ($item[0] >= $requesttime) {
                    // dd($item);
                    if (ClientDNS::where('timestamp', $item[0])->doesntExist()) {
                        // insert clientdns
                        $this->info("vpndata:insert dns data timestamp:$item[0]");
                        $clientdns = new ClientDNS;
                        $clientdns->client_ip = $item[3];
                        $clientdns->domain_name = $item[2];
                        $clientdns->type = $item[4];
                        $clientdns->timestamp = $item[0];
                        $clientdns->save();
                    }
                }
            });
        });

        $this->info('vpndata:Cron Cummand Run successfully!');
    }
}
