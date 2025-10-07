<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserProjectsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('user_projects')->delete();

        \DB::table('user_projects')->insert([
            0 => [
                'id' => 1,
                'user_id' => 1,
                'project_id' => 1,
                'created_at' => '2025-09-27 11:14:16',
                'updated_at' => '2025-09-27 11:30:47',
            ],
            1 => [
                'id' => 2,
                'user_id' => 2,
                'project_id' => 1,
                'created_at' => '2025-09-27 11:14:28',
                'updated_at' => '2025-09-27 11:16:57',
            ],
            2 => [
                'id' => 3,
                'user_id' => 3,
                'project_id' => 1,
                'created_at' => '2025-09-27 11:15:23',
                'updated_at' => '2025-09-27 11:30:59',
            ],
            3 => [
                'id' => 4,
                'user_id' => 2,
                'project_id' => 2,
                'created_at' => '2025-09-29 09:58:06',
                'updated_at' => '2025-09-29 09:58:06',
            ],
            4 => [
                'id' => 5,
                'user_id' => 4,
                'project_id' => 2,
                'created_at' => '2025-09-29 09:58:08',
                'updated_at' => '2025-09-29 09:58:08',
            ],
            5 => [
                'id' => 6,
                'user_id' => 1,
                'project_id' => 2,
                'created_at' => '2025-09-29 09:58:09',
                'updated_at' => '2025-09-29 09:58:09',
            ],
            6 => [
                'id' => 7,
                'user_id' => 5,
                'project_id' => 1,
                'created_at' => '2025-10-06 14:13:07',
                'updated_at' => '2025-10-06 14:15:13',
            ],
        ]);

    }
}
