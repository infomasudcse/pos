<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('name');
            $table->string('address');
            $table->string('phone')->nullable($value = true);
            $table->string('bin')->nullable($value = true);
            $table->string('musak')->nullable($value = true);
            $table->string('discount')->nullable($value = true);
            $table->timestamps();
        });

        DB::table('branches')->insert([
            'title'=>'Head Office',
            'name'=>'Head Office',
            'address'=>'Dhaka',
            'phone'=>'01234567890',
            'bin'=>'',
            'musak'=>'',
            'discount'=>''
        ]);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branches');
    }
}
