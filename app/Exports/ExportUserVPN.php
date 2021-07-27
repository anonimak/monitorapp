<?php

namespace App\Exports;

use App\ClientVPN;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class ExportUserVPN implements FromQuery, WithHeadings
{
    use Exportable;

    public function search(string $search = null)
    {
        $this->search = $search;

        return $this;
    }

    public function query()
    {
        $query = "id_vpn, online_status, platform, virt_address, real_address, mac_addr";
        if (isset($this->search)) {
            return ClientVPN::query()->select(DB::raw($query))
                ->where('id_vpn', 'LIKE', '%' . $this->search . '%')
                ->orWhere('platform', 'LIKE', '%' . $this->search . '%')
                ->orWhere('mac_addr', 'LIKE', '%' . $this->search . '%')
                ->orWhere('virt_address', 'LIKE', '%' . $this->search . '%');
        }
        return ClientVPN::query()->select(DB::raw($query));
    }

    public function headings(): array
    {
        return ["ID VPN", "ONLINE STATUS", "SISTEM OPERASI", "IP LOKAL", "IP PUBLIK", "MAC ADDRESS"];
    }
}
