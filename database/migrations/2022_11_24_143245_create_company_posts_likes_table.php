<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyPostsLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_posts_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->nullable()->references('id')->on('company_posts')->onDelete('cascade');
            $table->foreignId('profile_id')->nullable()->references('id')->on('profile_accounts')->onDelete('cascade');
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
        Schema::dropIfExists('company_posts_likes');
    }
}
