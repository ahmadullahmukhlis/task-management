<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DocumentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('documents')->delete();
        
        \DB::table('documents')->insert(array (
            0 => 
            array (
                'id' => 4,
                'title' => 'this is just fro test',
                'document' => 'public/1I37w1dxhsegURxt1WBIx2ilPcozD2LinpGOM3DE.png',
                'task_id' => 43,
                'created_at' => '2025-10-06 11:50:29',
                'updated_at' => '2025-10-06 11:50:29',
            ),
        ));
        
        
    }
}