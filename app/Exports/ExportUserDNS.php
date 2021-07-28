<?php

namespace App\Exports;

use App\ClientDNS;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class ExportUserDNS implements FromQuery, WithHeadings
{
    use Exportable;

    public function clientIp(string $clientip = null)
    {
        $this->clientip = $clientip;

        return $this;
    }

    public function search(string $search = null)
    {
        $this->search = $search;

        return $this;
    }

    public function query()
    {
        $query = "client_ip, domain_name, type, timestamp AS `date`";
        if (isset($this->search)) {
            $search = $this->search;
            return ClientDNS::select(DB::raw($query))
                ->where('client_ip', $this->clientip)
                ->where(function ($query) use ($search) {
                    $query->where('domain_name', 'LIKE', '%' . $search . '%');
                    $query->orWhere('client_ip', 'LIKE', '%' . $search . '%');
                });
        }
        return ClientDNS::select(DB::raw($query))->where('client_ip', $this->clientip);
    }

    public function headings(): array
    {
        return ["CLIENT IP", "DOMAIN NAME",  "TYPE", "TIMESTAMP"];
    }
}
