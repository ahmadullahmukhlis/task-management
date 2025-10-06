<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TaskActionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('task_actions')->delete();
        
        \DB::table('task_actions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 1,
                'task_id' => 1,
                'status' => 'completed',
                'created_at' => '2025-09-28 14:45:13',
                'updated_at' => '2025-09-28 15:46:05',
            ),
            1 => 
            array (
                'id' => 2,
                'user_id' => 1,
                'task_id' => 2,
                'status' => 'Pending',
                'created_at' => '2025-09-28 14:45:40',
                'updated_at' => '2025-09-28 15:13:04',
            ),
            2 => 
            array (
                'id' => 3,
                'user_id' => 4,
                'task_id' => 3,
                'status' => 'Pending',
                'created_at' => '2025-09-29 09:35:40',
                'updated_at' => '2025-09-29 09:39:22',
            ),
            3 => 
            array (
                'id' => 4,
                'user_id' => 4,
                'task_id' => 4,
                'status' => 'Pending',
                'created_at' => '2025-09-30 08:53:11',
                'updated_at' => '2025-09-30 10:28:42',
            ),
            4 => 
            array (
                'id' => 5,
                'user_id' => 1,
                'task_id' => 5,
                'status' => 'completed',
                'created_at' => '2025-10-04 14:27:17',
                'updated_at' => '2025-10-04 14:27:17',
            ),
            5 => 
            array (
                'id' => 6,
                'user_id' => 1,
                'task_id' => 45,
                'status' => 'completed',
                'created_at' => '2025-10-06 16:39:14',
                'updated_at' => '2025-10-06 16:39:14',
            ),
        ));
        
        
    }
}