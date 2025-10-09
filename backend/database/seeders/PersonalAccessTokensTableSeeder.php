<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PersonalAccessTokensTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('personal_access_tokens')->delete();

        \DB::table('personal_access_tokens')->insert([
            0 => [
                'id' => 12,
                'tokenable_type' => 'App\\Models\\User',
                'tokenable_id' => 1,
                'name' => 'user_token',
                'token' => '5ae355e9c1b7b48aa895cbc89b4bfc8e76609635f6f78b87892f0567a1f58faa',
                'abilities' => '["*"]',
                'last_used_at' => '2025-10-06 16:39:14',
                'expires_at' => null,
                'created_at' => '2025-10-06 16:36:02',
                'updated_at' => '2025-10-06 16:39:14',
            ],
        ]);

    }
}
