<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('projects')->delete();
        
        \DB::table('projects')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'web development',
                'comment' => 'this is the web developement&nbsp;',
                'created_at' => '2025-09-27 09:14:34',
                'updated_at' => '2025-09-27 09:14:34',
                'created_by' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'project first',
                'comment' => 'this is afhsaf safor the test&nbsp;',
                'created_at' => '2025-09-29 09:26:34',
                'updated_at' => '2025-09-29 09:26:34',
                'created_by' => 4,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'test',
                'comment' => 'new test',
                'created_at' => '2025-09-30 08:52:41',
                'updated_at' => '2025-09-30 08:52:41',
                'created_by' => 4,
            ),
        ));
        
        
    }
}