<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('users')->delete();

        \DB::table('users')->insert([
            0 => [
                'id' => 1,
                'image' => null,
                'first_name' => 'Ahmad Edris',
                'last_name' => 'Malia',
                'email' => 'edris.malya@dab.gov.af',
                'email_verified_at' => null,
                'password' => '$2y$10$iYR7gYXTOZhgkI03hsQ4FudLJwtaBLcBVVn6KVsgY59/ht4lO1736',
                'is_active' => 1,
                'is_verified' => 1,
                'change_password' => 0,
                'remember_token' => null,
                'created_at' => '2023-09-11 18:51:48',
                'updated_at' => '2023-09-11 18:51:48',
            ],
            1 => [
                'id' => 2,
                'image' => 'http://localhost:8000/storage/users-profile/PbsodESXpLiiNAyxpNi6fLuyptW5Ccp61o74obE3.png',
                'first_name' => 'Ahmad Edris',
                'last_name' => 'Malia',
                'email' => 'adrismalya@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$10$wmb2lfixtvdsIhkR55IX4uoGQVAFu0z3iR/9efgC5/Re/y1Emu97a',
                'is_active' => 1,
                'is_verified' => 1,
                'change_password' => 0,
                'remember_token' => null,
                'created_at' => '2023-09-11 18:55:34',
                'updated_at' => '2024-04-17 01:19:44',
            ],
            2 => [
                'id' => 14,
                'image' => null,
                'first_name' => 'مخلص',
                'last_name' => '',
                'email' => 'ahmadullahmukhlis2019@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$10$9j0myp1XbSvuNhShy2IoJO5NF0y9sBbjNTWvoDZHVsnTI3ybkji9K',
                'is_active' => 0,
                'is_verified' => 1,
                'change_password' => 1,
                'remember_token' => null,
                'created_at' => '2025-10-06 16:16:49',
                'updated_at' => '2025-10-06 16:16:49',
            ],
        ]);

    }
}
