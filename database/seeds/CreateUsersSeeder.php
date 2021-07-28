<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name' => 'User',
                'email' => 'user@user.com',
                'email_verified_at' => now(),
                'password' => Hash::make('kosong'),
                'remember_token' => Str::random(10),
            ],
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
