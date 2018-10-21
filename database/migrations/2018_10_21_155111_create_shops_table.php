<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shop_category_id');
            $table->string('shop_name')->index();
            $table->string('shop_img')->nullable();
            $table->float('shop_rating')->comment('店铺评分');
            $table->float('start_send')->comment('起送金额');
            $table->float('send_cost')->comment('配送费');
            $table->string('notice')->comment('店公告');
            $table->string('discount')->comment('优惠信息');
            $table->integer('status')->comment('1正常,0待审核,-1禁用');
            $table->integer('advantage')->default('0')->comment('店铺优势');
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
        Schema::dropIfExists('shops');
    }
}
