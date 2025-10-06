<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LoginLogsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('login_logs')->delete();
        
        \DB::table('login_logs')->insert(array (
            0 => 
            array (
                'id' => 1,
                'email' => 'edris.malya@dab.gov.af',
                'ip_address' => '127.0.0.1',
                'login_succeed' => 1,
                'login_token' => '1|a0oceVtoj0zYDIRA8g809k5sZtJGNSPAOyricx7133394c33',
                'message' => 'Logged in successfully.',
                'created_at' => '2025-09-24 14:04:24',
                'updated_at' => '2025-09-24 14:04:24',
            ),
            1 => 
            array (
                'id' => 2,
                'email' => 'edris.malya@dab.gov.af',
                'ip_address' => '127.0.0.1',
                'login_succeed' => 1,
                'login_token' => '2|ZhY0JISc6M24wqzalENggz5UtZCpOaogCLghB2hf5f0546b0',
                'message' => 'Logged in successfully.',
                'created_at' => '2025-09-24 15:04:03',
                'updated_at' => '2025-09-24 15:04:03',
            ),
            2 => 
            array (
                'id' => 3,
                'email' => 'edris.malya@dab.gov.af',
                'ip_address' => '127.0.0.1',
                'login_succeed' => 1,
                'login_token' => '3|7DGRyJzBie3BfvJ1zge0RpMrsHmBZN5PwdXHlhwKae3d56a0',
                'message' => 'Logged in successfully.',
                'created_at' => '2025-09-24 15:18:06',
                'updated_at' => '2025-09-24 15:18:06',
            ),
            3 => 
            array (
                'id' => 4,
                'email' => 'edris.malya@dab.gov.af',
                'ip_address' => '127.0.0.1',
                'login_succeed' => 1,
                'login_token' => '4|t0IzXP5c6o4tuTSFXaTQqVw8EOjxeLJy9UKNutZm7fdaed71',
                'message' => 'Logged in successfully.',
                'created_at' => '2025-09-25 09:50:19',
                'updated_at' => '2025-09-25 09:50:19',
            ),
            4 => 
            array (
                'id' => 5,
                'email' => 'ahmadullahmukhlis2019@gmail.com',
                'ip_address' => '127.0.0.1',
                'login_succeed' => 0,
                'login_token' => NULL,
                'message' => 'User is inactive.',
                'created_at' => '2025-09-28 14:15:41',
                'updated_at' => '2025-09-28 14:15:41',
            ),
            5 => 
            array (
                'id' => 6,
                'email' => 'edris.malya@dab.gov.af',
                'ip_address' => '127.0.0.1',
                'login_succeed' => 0,
                'login_token' => NULL,
                'message' => 'The provided credentials are incorrect.',
                'created_at' => '2025-09-28 14:15:58',
                'updated_at' => '2025-09-28 14:15:58',
            ),
            6 => 
            array (
                'id' => 7,
                'email' => 'edris.malya@dab.gov.af',
                'ip_address' => '127.0.0.1',
                'login_succeed' => 1,
                'login_token' => '5|7PK73gNDjtr2o3a0a7RD6BrlhzRuYbLOQi2qJydpb6705ae7',
                'message' => 'Logged in successfully.',
                'created_at' => '2025-09-28 14:16:26',
                'updated_at' => '2025-09-28 14:16:26',
            ),
            7 => 
            array (
                'id' => 8,
                'email' => 'ahmadullahmukhlis2019@gmail.com',
                'ip_address' => '127.0.0.1',
                'login_succeed' => 1,
                'login_token' => '6|Jq1qezmrgWHV8xjQ1g8ING3CCSt4EFkXWpf7No7Y6b3b7969',
                'message' => 'Logged in successfully.',
                'created_at' => '2025-09-29 09:22:44',
                'updated_at' => '2025-09-29 09:22:44',
            ),
            8 => 
            array (
                'id' => 9,
                'email' => 'ahmadullahmukhlis2019@gmail.com',
                'ip_address' => '127.0.0.1',
                'login_succeed' => 0,
                'login_token' => NULL,
                'message' => 'User is inactive.',
                'created_at' => '2025-10-04 13:44:41',
                'updated_at' => '2025-10-04 13:44:41',
            ),
            9 => 
            array (
                'id' => 10,
                'email' => 'edris.malya@dab.gov.af',
                'ip_address' => '127.0.0.1',
                'login_succeed' => 1,
                'login_token' => '7|XTE1iAX0Le1cgOwUBYmd4EUC81GW18Y5UAbJFYsO4340f8d9',
                'message' => 'Logged in successfully.',
                'created_at' => '2025-10-04 13:47:20',
                'updated_at' => '2025-10-04 13:47:20',
            ),
            10 => 
            array (
                'id' => 11,
                'email' => 'ahmadullahmukhlis2019@gmail.com',
                'ip_address' => '127.0.0.1',
                'login_succeed' => 0,
                'login_token' => NULL,
                'message' => 'User is inactive.',
                'created_at' => '2025-10-06 15:56:21',
                'updated_at' => '2025-10-06 15:56:21',
            ),
            11 => 
            array (
                'id' => 12,
                'email' => 'saidshah.hamid@dab.gov.af',
                'ip_address' => '10.0.5.71',
                'login_succeed' => 0,
                'login_token' => NULL,
                'message' => 'The provided credentials are incorrect.',
                'created_at' => '2025-10-06 16:29:47',
                'updated_at' => '2025-10-06 16:29:47',
            ),
            12 => 
            array (
                'id' => 13,
                'email' => 'adrismalya@gmail.com',
                'ip_address' => '10.0.5.71',
                'login_succeed' => 0,
                'login_token' => NULL,
                'message' => 'The provided credentials are incorrect.',
                'created_at' => '2025-10-06 16:30:18',
                'updated_at' => '2025-10-06 16:30:18',
            ),
            13 => 
            array (
                'id' => 14,
                'email' => 'adrismalya@gmail.com',
                'ip_address' => '10.0.5.71',
                'login_succeed' => 0,
                'login_token' => NULL,
                'message' => 'The provided credentials are incorrect.',
                'created_at' => '2025-10-06 16:30:26',
                'updated_at' => '2025-10-06 16:30:26',
            ),
            14 => 
            array (
                'id' => 15,
                'email' => 'adrismalya@gmail.com',
                'ip_address' => '10.0.5.71',
                'login_succeed' => 1,
                'login_token' => '8|EsDeuH6R3ruhdbwq4psmt4KPyrbwlHuO5JcFWmOE570fed9b',
                'message' => 'Logged in successfully.',
                'created_at' => '2025-10-06 16:30:30',
                'updated_at' => '2025-10-06 16:30:30',
            ),
            15 => 
            array (
                'id' => 16,
                'email' => 'edris.malya@dab.gov.af',
                'ip_address' => '10.0.5.71',
                'login_succeed' => 0,
                'login_token' => NULL,
                'message' => 'The provided credentials are incorrect.',
                'created_at' => '2025-10-06 16:32:08',
                'updated_at' => '2025-10-06 16:32:08',
            ),
            16 => 
            array (
                'id' => 17,
                'email' => 'edris.malya@dab.gov.af',
                'ip_address' => '10.0.5.71',
                'login_succeed' => 1,
                'login_token' => '9|Ag0j5e9la4GVagOsn9gD8ubL8A1azO1tlRniew58f8896f9a',
                'message' => 'Logged in successfully.',
                'created_at' => '2025-10-06 16:32:19',
                'updated_at' => '2025-10-06 16:32:19',
            ),
            17 => 
            array (
                'id' => 18,
                'email' => 'adrismalya@gmail.com',
                'ip_address' => '10.0.5.71',
                'login_succeed' => 1,
                'login_token' => '10|zkuOUSth4EVDJUi2OaFgorpNgoQZzP8k4scSGfDr3cb2aaa5',
                'message' => 'Logged in successfully.',
                'created_at' => '2025-10-06 16:32:56',
                'updated_at' => '2025-10-06 16:32:56',
            ),
            18 => 
            array (
                'id' => 19,
                'email' => 'adrismalya@gmail.com',
                'ip_address' => '10.0.5.71',
                'login_succeed' => 1,
                'login_token' => '11|LVmqVlZwWsMd6qfYQhCE36KrEWrCuLVtGIDKC9tea911945e',
                'message' => 'Logged in successfully.',
                'created_at' => '2025-10-06 16:35:36',
                'updated_at' => '2025-10-06 16:35:36',
            ),
            19 => 
            array (
                'id' => 20,
                'email' => 'edris.malya@dab.gov.af',
                'ip_address' => '10.0.5.71',
                'login_succeed' => 0,
                'login_token' => NULL,
                'message' => 'The provided credentials are incorrect.',
                'created_at' => '2025-10-06 16:35:56',
                'updated_at' => '2025-10-06 16:35:56',
            ),
            20 => 
            array (
                'id' => 21,
                'email' => 'edris.malya@dab.gov.af',
                'ip_address' => '10.0.5.71',
                'login_succeed' => 0,
                'login_token' => NULL,
                'message' => 'The provided credentials are incorrect.',
                'created_at' => '2025-10-06 16:35:58',
                'updated_at' => '2025-10-06 16:35:58',
            ),
            21 => 
            array (
                'id' => 22,
                'email' => 'edris.malya@dab.gov.af',
                'ip_address' => '10.0.5.71',
                'login_succeed' => 1,
                'login_token' => '12|rOSa6XJstu6V0hX4WdaMstSfXHkhQKpL62bLsBzpc6e9de78',
                'message' => 'Logged in successfully.',
                'created_at' => '2025-10-06 16:36:02',
                'updated_at' => '2025-10-06 16:36:02',
            ),
        ));
        
        
    }
}