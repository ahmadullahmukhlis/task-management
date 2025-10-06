<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserVerificationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('user_verifications')->delete();
        
        \DB::table('user_verifications')->insert(array (
            0 => 
            array (
                'id' => 28,
                'user_id' => 14,
                'otp' => '4016665',
                'expires_at' => '2025-10-06 19:16:49',
                'status' => 'pending',
                'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0',
                'device' => 'desktop',
                'created_at' => '2025-10-06 16:16:49',
                'updated_at' => '2025-10-06 16:16:49',
            ),
        ));
        
        
    }
}