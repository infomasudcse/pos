<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('total_item');
            $table->double('subtotal',8,2);
            $table->double('total_sale',8,2);
            $table->double('totalWTax',8,2);
            $table->double('changeamount',8,2);
            $table->double('total_payment',8,2);
            $table->double('total_tax',8,2);
            $table->double('total_discount',8,2)->default(0.00);
            $table->integer('user_id');            
            $table->integer('branch_id');
            $table->integer('customer_id')->nullable();
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
        Schema::dropIfExists('sales');
    }
}
