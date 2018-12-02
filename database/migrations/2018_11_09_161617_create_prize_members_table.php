<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrizeMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prize_members', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('prize_id')->comment('试用品id');
            $table->integer('member_id')->comment('会员id');
            $table->tinyInteger('is_won')->default(0)->comment('是否中奖,1是,0否');
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
        Schema::dropIfExists('prize_members');
    }
}
