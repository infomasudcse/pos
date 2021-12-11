<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSystemstatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('systemstatus', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['on', 'off']);
            $table->timestamps();
        });

         DB::table('systemstatus')->insert(
        [ 'status' => 'on']
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('systemstatus');
    }
}
