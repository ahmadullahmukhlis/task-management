<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserTasksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('user_tasks')->delete();
        
        \DB::table('user_tasks')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 1,
                'task_id' => 1,
                'created_at' => '2025-09-28 14:19:12',
                'updated_at' => '2025-09-28 14:19:12',
            ),
            1 => 
            array (
                'id' => 2,
                'user_id' => 2,
                'task_id' => 1,
                'created_at' => '2025-09-28 14:19:45',
                'updated_at' => '2025-09-28 14:19:45',
            ),
            2 => 
            array (
                'id' => 3,
                'user_id' => 3,
                'task_id' => 2,
                'created_at' => '2025-09-28 15:13:32',
                'updated_at' => '2025-09-28 15:13:32',
            ),
            3 => 
            array (
                'id' => 4,
                'user_id' => 1,
                'task_id' => 3,
                'created_at' => '2025-09-29 09:58:22',
                'updated_at' => '2025-09-29 09:58:22',
            ),
            4 => 
            array (
                'id' => 5,
                'user_id' => 2,
                'task_id' => 3,
                'created_at' => '2025-09-29 10:05:59',
                'updated_at' => '2025-09-29 10:05:59',
            ),
            5 => 
            array (
                'id' => 6,
                'user_id' => 1,
                'task_id' => 4,
                'created_at' => '2025-09-30 08:52:23',
                'updated_at' => '2025-09-30 08:52:23',
            ),
            6 => 
            array (
                'id' => 9,
                'user_id' => 1,
                'task_id' => 6,
                'created_at' => '2025-10-04 14:36:26',
                'updated_at' => '2025-10-04 14:36:26',
            ),
            7 => 
            array (
                'id' => 12,
                'user_id' => 1,
                'task_id' => 42,
                'created_at' => '2025-10-05 16:41:10',
                'updated_at' => '2025-10-05 16:41:10',
            ),
            8 => 
            array (
                'id' => 13,
                'user_id' => 1,
                'task_id' => 44,
                'created_at' => '2025-10-06 16:37:13',
                'updated_at' => '2025-10-06 16:37:13',
            ),
            9 => 
            array (
                'id' => 14,
                'user_id' => 1,
                'task_id' => 45,
                'created_at' => '2025-10-06 16:37:59',
                'updated_at' => '2025-10-06 16:37:59',
            ),
            10 => 
            array (
                'id' => 15,
                'user_id' => 2,
                'task_id' => 45,
                'created_at' => '2025-10-06 16:37:59',
                'updated_at' => '2025-10-06 16:37:59',
            ),
        ));
        
        
    }
}