<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderCheckouts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_checkouts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->integer('store_id');
            $table->integer('table_no')->nullable()->commnet('桌號');
            $table->integer('number')->nullable()->commnet('流水號');
            $table->json('details')->commnet('點餐詳細');
            $table->integer('total_price')->nullable()->commnet('總金額');
            $table->integer('is_takeout')->commnet('外帶')->default("0");
            $table->integer('is_finished')->commnet('已經完成')->default("0");
            $table->timestamps();

            $table->index(['store_id', 'is_finished']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_checkouts');
    }
}
