<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientvpnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientvpn', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 255);
            $table->string('device_name', 255);
            $table->string('type', 50);
            $table->string('mac_addr', 100);
            $table->string('virt_address', 18);
            $table->string('virt_address6', 180);
            $table->string('network', 18);
            $table->string('real_address', 18);
            $table->boolean('online_status')->default(1);
            $table->timestamps();
        });

        Schema::create('clientdns', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 255);
            $table->integer('timestamp');
            $table->string('type_ip', 5);
            $table->string('domain_name', 255);
            $table->string('client_ip', 18);
            $table->integer('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientvpn');
        Schema::dropIfExists('clientdns');
    }
}
