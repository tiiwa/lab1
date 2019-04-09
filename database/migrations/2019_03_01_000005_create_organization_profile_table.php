<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationProfileTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('organization_profile', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organization_id')->nullable();
            //$table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->string('profile_id')->nullable();
            //$table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade');
            $table->string('role')->nullable();
            $table->string('metadata')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('organization_profile');
    }
}
