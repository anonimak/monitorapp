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
        Schema::create('User_vpn', function (Blueprint $table) {
            $table->id();
            $table->string('id_user', 50);
            $table->boolean('online_status')->default(1);
            $table->string('sistem_operasi', 18);
            $table->string('ip_lokal', 18);
            $table->string('ip_publik', 18);
            $table->string('mac_addr', 20);
            $table->timestamps();
        });

        Schema::create('Domain', function (Blueprint $table) {
            $table->bigIncrements('id_domain');
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
        Schema::dropIfExists('User_vpn');
        Schema::dropIfExists('Domain');
    }
}
