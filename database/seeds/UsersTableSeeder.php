<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
                'username' => 'jyoansah',
                'email' => 'yaw@tiiwaafrica.com',
                'password' => '$2y$12$MiOa3xd3l3MYu..6VtCFTuKhCHJd5tY90/3qKXuP7L2iNjradUjtq',
                'status' => 'activated',
            ]);

        factory(App\User::class, 50)->create()->each(function ($user) {
            $profile = factory(App\Profile::class)->make();
            $profile->user_id = $user->id;
            $profile->save();
        });
    }
}
