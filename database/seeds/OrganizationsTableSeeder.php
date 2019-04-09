<?php

use Illuminate\Database\Seeder;

class OrganizationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        factory(App\Organization::class, 50)->create()->each(function ($org) {
            $profile = factory(App\Profile::class)->create();
            $org->people()->attach($profile->id, ['role' => 'director']);
            $profile = factory(App\Profile::class)->create();
            $org->people()->attach($profile->id, ['role' => 'poc']);
        });
    }
}
