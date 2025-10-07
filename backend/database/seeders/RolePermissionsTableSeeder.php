<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolePermissionsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('role_permissions')->delete();

        \DB::table('role_permissions')->insert([
            0 => [
                'role_id' => 1,
                'permission_id' => 1,
            ],
            1 => [
                'role_id' => 1,
                'permission_id' => 2,
            ],
            2 => [
                'role_id' => 1,
                'permission_id' => 3,
            ],
            3 => [
                'role_id' => 1,
                'permission_id' => 4,
            ],
            4 => [
                'role_id' => 1,
                'permission_id' => 5,
            ],
            5 => [
                'role_id' => 1,
                'permission_id' => 6,
            ],
            6 => [
                'role_id' => 1,
                'permission_id' => 7,
            ],
            7 => [
                'role_id' => 1,
                'permission_id' => 8,
            ],
            8 => [
                'role_id' => 1,
                'permission_id' => 9,
            ],
            9 => [
                'role_id' => 1,
                'permission_id' => 10,
            ],
            10 => [
                'role_id' => 1,
                'permission_id' => 14,
            ],
            11 => [
                'role_id' => 1,
                'permission_id' => 11,
            ],
            12 => [
                'role_id' => 1,
                'permission_id' => 12,
            ],
            13 => [
                'role_id' => 1,
                'permission_id' => 13,
            ],
            14 => [
                'role_id' => 1,
                'permission_id' => 15,
            ],
            15 => [
                'role_id' => 1,
                'permission_id' => 21,
            ],
            16 => [
                'role_id' => 1,
                'permission_id' => 22,
            ],
            17 => [
                'role_id' => 1,
                'permission_id' => 16,
            ],
            18 => [
                'role_id' => 1,
                'permission_id' => 20,
            ],
            19 => [
                'role_id' => 1,
                'permission_id' => 17,
            ],
            20 => [
                'role_id' => 1,
                'permission_id' => 18,
            ],
            21 => [
                'role_id' => 1,
                'permission_id' => 19,
            ],
            22 => [
                'role_id' => 1,
                'permission_id' => 23,
            ],
            23 => [
                'role_id' => 1,
                'permission_id' => 24,
            ],
            24 => [
                'role_id' => 1,
                'permission_id' => 25,
            ],
            25 => [
                'role_id' => 1,
                'permission_id' => 26,
            ],
            26 => [
                'role_id' => 1,
                'permission_id' => 27,
            ],
            27 => [
                'role_id' => 1,
                'permission_id' => 28,
            ],
        ]);

    }
}
