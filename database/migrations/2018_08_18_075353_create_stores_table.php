<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->text('name')->comment('店名');
            $table->text('tel')->comment('電話');
            $table->text('address')->comment('地址');
            $table->text('information')->comment('資訊 格式 json')->nullable();
            $table->integer('table_total')->comment('總桌數')->default(1);
            $table->smallInteger('enable')->comment('開啟')->default('1');
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
        Schema::dropIfExists('stores');
    }
}
