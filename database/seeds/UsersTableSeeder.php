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
                'email' => 'yaw@tiiwaafrica.com',
                'password' => '$2y$12$MiOa3xd3l3MYu..6VtCFTuKhCHJd5tY90/3qKXuP7L2iNjradUjtq',
                'status' => 'activated',
            ]);
    }
}
