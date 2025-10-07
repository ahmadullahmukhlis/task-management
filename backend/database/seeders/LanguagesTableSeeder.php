<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('languages')->delete();

        \DB::table('languages')->insert([
            0 => [
                'id' => 1,
                'name' => 'دری',
                'abbr' => 'da',
                'status' => 1,
                'direction' => 'rtl',
                'created_at' => '2023-09-27 17:45:49',
                'updated_at' => '2023-09-27 17:45:49',
            ],
        ]);

    }
}
