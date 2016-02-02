<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->string('permalink', 255)->nullable();
            $table->string('banner', 200)->nullable();
            $table->string('banner_source', 255)->nullable();
            $table->string('source', 255)->nullable();
            $table->string('title', 255);
            $table->text('desc')->nullable();
            $table->string('tag', 64)->nullable();
            $table->longText('content');
            $table->string('question', 255);
            $table->dateTime('start_date')->nullable();
            $table->string('status', 32)->default('pending');
            $table->integer('visit')->default(0);
            $table->integer('user_id')->unsigned()->nullable()->default('1');
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
        Schema::drop('news');
    }
}
