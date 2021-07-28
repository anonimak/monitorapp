<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ClientVPNMongo extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'clients';
    protected $fillable = [
        'first_name', 'last_name', 'address'
    ];
}
