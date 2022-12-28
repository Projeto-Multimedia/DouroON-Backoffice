<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavePlaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('save_place', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->nullable()->references('id')->on('profile_accounts')->onDelete('cascade');
            $table->foreignId('place_id')->nullable()->references('id')->on('company_places')->onDelete('cascade');
            $table->foreignId('route_id')->nullable()->references('id')->on('user_routes')->onDelete('cascade');
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
        Schema::dropIfExists('save_place');
    }
}
