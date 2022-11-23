<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyFollowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_followers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_loggedIn_id')->nullable()->references('id')->on('profile_accounts')->onDelete('cascade');
            $table->foreignId('account_id')->nullable()->references('id')->on('profile_accounts')->onDelete('cascade');
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
        Schema::dropIfExists('company_followers');
    }
}
