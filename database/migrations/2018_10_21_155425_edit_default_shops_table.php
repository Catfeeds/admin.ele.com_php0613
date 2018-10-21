<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditDefaultShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //修改shops字段默认值
        Schema::table('shops', function (Blueprint $table) {
            $table->string('shop_name',50)->change();
            $table->float('shop_rating')->default(5)->change();
            $table->float('start_send')->default(0)->change();
            $table->float('send_cost')->default(0)->change();
            $table->text('notice')->nullable()->change();
            $table->string('discount')->nullable()->change();
            $table->integer('status')->default(1)->change();
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
