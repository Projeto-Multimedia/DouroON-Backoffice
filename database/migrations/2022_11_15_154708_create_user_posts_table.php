<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('user_posts');
        Schema::create('user_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enduser_id')->nullable()->references('id')->on('end_users')->onDelete('cascade');
            $table->string('image');
            $table->text('description')->nullable();
            $table->string('location')->nullable();
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
        Schema::dropIfExists('user_posts');
    }
}
