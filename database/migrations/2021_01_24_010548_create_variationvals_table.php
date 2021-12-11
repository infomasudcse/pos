<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariationvalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variationvals', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('variation_id');
            $table->foreign('variation_id')->references('id')->on('variations');
            $table->string('value',20);
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
        Schema::dropIfExists('variationvals');
    }
}
