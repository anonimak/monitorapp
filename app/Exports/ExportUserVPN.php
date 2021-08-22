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
        $query = "id_user, online_status, sistem_operasi, ip_lokal, ip_publik, mac_addr";
        if (isset($this->search)) {
            return ClientVPN::query()->select(DB::raw($query))
                ->where('id_user', 'LIKE', '%' . $this->search . '%')
                ->orWhere('sistem_operasi', 'LIKE', '%' . $this->search . '%')
                ->orWhere('mac_addr', 'LIKE', '%' . $this->search . '%')
                ->orWhere('ip_lokal', 'LIKE', '%' . $this->search . '%');
        }
        return ClientVPN::query()->select(DB::raw($query));
    }

    public function headings(): array
    {
        return ["ID VPN", "ONLINE STATUS", "SISTEM OPERASI", "IP LOKAL", "IP PUBLIK", "MAC ADDRESS"];
    }
}
