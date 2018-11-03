<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //shops添加字段
        Schema::table('shops', function (Blueprint $table) {
            $table->boolean('brand')->comment('品牌');
            $table->boolean('on_time')->comment('准时送');
            $table->boolean('fengniao')->comment('蜂鸟');
            $table->boolean('bao')->comment('保标记');
            $table->boolean('piao')->comment('票标记');
            $table->boolean('zhun')->comment('准标记');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
