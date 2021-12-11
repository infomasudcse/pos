<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->default('admin')->unique();
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role',10)->default('staff');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->text('profile_photo_path')->nullable();
            $table->tinyInteger('branch_id')->default(1);
            //$table->foreign('branch_id')->references('id')->on('branches');
            $table->float('unit_salary',4,2)->nullable();
            $table->string('phone',20)->default('0123456789');
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('canTransfer')->default(0);
            $table->timestamps();
        });

        DB::table('users')->insert(
            [ 'name' => 'admin',
                'username' => 'admin',
                'password'=> Hash::make('123456789'),
                'role'=>'admin'            
                ]
            );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
