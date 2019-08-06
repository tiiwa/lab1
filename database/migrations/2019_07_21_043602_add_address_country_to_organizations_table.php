<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddressCountryToOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->string('address');
            $table->enum('country', AddAddressCountryToOrganizationsTable::getAfricanCountries());
            $table->index('name');
            $table->index('country');
            $table->index('sector');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropColumn(['address', 'country']);
            $table->dropIndex('organizations_name_index');
            // deleting the column deletes the index
            // $table->dropIndex('organizations_country_index');
            $table->dropIndex('organizations_sector_index');
        });
    }

    public static function getAfricanCountries()
    {
        $data = shell_exec('node ./getCountries.js names');
        return array_map('addslashes', json_decode($data));
    }
}
