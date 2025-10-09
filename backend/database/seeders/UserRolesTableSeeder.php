<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('user_roles')->delete();

        \DB::table('user_roles')->insert([
            0 => [
                'user_id' => 2,
                'role_id' => 2,
            ],
        ]);

    }
}
