<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientVPN extends Model
{
    //
    protected $table = 'User_vpn';
    protected $guarded = [];
    // protected $fillable = [
    //     'first_name', 'last_name', 'address'
    // ];
    // protected $hidden = [
    //     'password', 'remember_token',
    // ];

    public static function getData($search = null)
    {
        $data = Self::select('*')
            ->orderBy('online_status', 'desc');

        if ($search) {
            $data->where('id_user', 'LIKE', '%' . $search . '%');
            $data->orWhere('sistem_operasi', 'LIKE', '%' . $search . '%');
            $data->orWhere('mac_addr', 'LIKE', '%' . $search . '%');
            $data->orWhere('ip_lokal', 'LIKE', '%' . $search . '%');
        }
        return $data;
    }
}
