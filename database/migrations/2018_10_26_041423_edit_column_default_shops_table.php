<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditColumnDefaultShopsTable extends Migration
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
            $table->boolean('brand')->default(0)->change();
            $table->boolean('on_time')->default(0)->change();
            $table->boolean('fengniao')->default(0)->change();
            $table->boolean('bao')->default(0)->change();
            $table->boolean('piao')->default(0)->change();
            $table->boolean('zhun')->default(0)->change();
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
