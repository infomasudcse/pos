<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackinventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trackinventories', function (Blueprint $table) {
            $table->id();
             $table->integer('inventory_id');           
            $table->integer('item_id');                      
            $table->integer('user_id');
            $table->integer('branch_id');
            $table->string('sku',30);
            $table->integer('qty');
            $table->string('comment');
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
        Schema::dropIfExists('trackinventories');
    }
}
