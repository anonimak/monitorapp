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
        // ini skema yang bakal jadi di db mysql
        Schema::create('vpn', function (Blueprint $table) {
            $table->id();
            $table->string('id_vpn', 255);
            $table->boolean('online_status')->default(1);
            $table->string('platform', 18);
            $table->string('virt_address', 18);
            $table->string('real_address', 18);
            $table->string('mac_addr', 20);
            $table->timestamps();
        });

        Schema::create('dns', function (Blueprint $table) {
            $table->id();
            $table->string('client_ip', 18);
            $table->string('domain_name', 255);
            $table->integer('type');
            $table->integer('timestamp');
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
