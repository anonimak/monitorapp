<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientVPN extends Model
{
    //
    protected $table = 'clientvpn';
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
            $data->where('user_id', 'LIKE', '%' . $search . '%');
            $data->orWhere('device_name', 'LIKE', '%' . $search . '%');
            $data->orWhere('mac_addr', 'LIKE', '%' . $search . '%');
            $data->orWhere('virt_address', 'LIKE', '%' . $search . '%');
            $data->orWhere('virt_address6', 'LIKE', '%' . $search . '%');
        }
        return $data;
    }
}
