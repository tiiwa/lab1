<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index()->nullable();
            $table->string('address')->nullable();
            $table->text('description')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('size_range')->nullable();
            $table->string('legal_entity_type')->nullable();
            $table->text('summary_of_needs')->nullable();
            $table->string('audience')->nullable();
            $table->string('inception_date')->nullable();
            $table->string('target_locations')->nullable();
            $table->string('industry')->index()->nullable();
            $table->string('impact_area')->index()->nullable();
            $table->string('facebook_profile')->nullable();
            $table->string('twitter_profile')->nullable();
            $table->string('instagram_profile')->nullable();
            $table->string('funding_status')->nullable();
            $table->string('funding_type')->nullable();
            $table->string('operating_language')->nullable();
            $table->string('method_of_collection')->nullable();
            $table->string('country')->index()->nullable();
            $table->boolean('approved')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('organizations');
    }
}
