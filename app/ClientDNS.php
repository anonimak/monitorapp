<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ClientDNS extends Model
{
    protected $table = 'Domain';
    protected $primaryKey = 'id_domain';
    protected $guarded = [];
    // protected $fillable = [
    //     'first_name', 'last_name', 'address'
    // ];
    // protected $hidden = [
    //     'password', 'remember_token',
    // ];

    public static function getData($ip, $search = null)
    {
        $data = Self::select('*')
            ->orderBy('created_at', 'desc');
        $data->where('client_ip', $ip);
        // dd($search);
        if ($search) {
            $data->where(function ($query) use ($search) {
                $query->where('domain_name', 'LIKE', '%' . $search . '%');
                $query->orWhere('client_ip', 'LIKE', '%' . $search . '%');
            });
        }
        return $data;
    }

    public static function getTopDomain(array $type, int $limit)
    {
        return Self::select(DB::raw("count(domain_name) total_domain, domain_name"))->whereIn('type', $type)->groupBy('domain_name')->orderByDesc('total_domain')->limit($limit)->get();
    }
}
