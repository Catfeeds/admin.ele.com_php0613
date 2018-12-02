<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //新建导航表
        Schema::create('navs', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name');
        $table->string('url')->comment('地址');
        $table->integer('permission_id')->comment('关联权限id');
        $table->integer('pid')->default(0)->comment('父级id');
        $table->integer('sort')->default(10)->nullable()->comment('排序');
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
        Schema::dropIfExists('navs');
    }
}
