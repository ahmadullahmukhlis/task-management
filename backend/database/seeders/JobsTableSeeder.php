<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class JobsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('jobs')->delete();

        \DB::table('jobs')->insert([
            0 => [
                'id' => 55,
                'queue' => 'default',
                'payload' => '{"uuid":"97712ba6-2ba9-4092-b1fc-6e8896e71bdb","displayName":"App\\\\Jobs\\\\FetcherSeedFilesJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\FetcherSeedFilesJob","command":"O:28:\\"App\\\\Jobs\\\\FetcherSeedFilesJob\\":0:{}"}}',
                'attempts' => 1,
                'reserved_at' => 1759752689,
                'available_at' => 1759746045,
                'created_at' => 1759746045,
            ],
            1 => [
                'id' => 56,
                'queue' => 'default',
                'payload' => '{"uuid":"4446d329-d97c-4084-83e0-b9482ef5a499","displayName":"App\\\\Mail\\\\OtpLoginMail","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Mail\\\\SendQueuedMailable","command":"O:34:\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\":15:{s:8:\\"mailable\\";O:21:\\"App\\\\Mail\\\\OtpLoginMail\\":4:{s:3:\\"otp\\";i:8798960;s:4:\\"user\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:15:\\"App\\\\Models\\\\User\\";s:2:\\"id\\";i:6;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}s:2:\\"to\\";a:1:{i:0;a:2:{s:4:\\"name\\";N;s:7:\\"address\\";s:31:\\"ahmadullahmukhlis2019@gmail.com\\";}}s:6:\\"mailer\\";s:4:\\"smtp\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:13:\\"maxExceptions\\";N;s:17:\\"shouldBeEncrypted\\";b:0;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;s:3:\\"job\\";N;}"}}',
                'attempts' => 0,
                'reserved_at' => null,
                'available_at' => 1759750087,
                'created_at' => 1759750087,
            ],
            2 => [
                'id' => 57,
                'queue' => 'default',
                'payload' => '{"uuid":"407b2169-39ed-4ae1-963f-22b944f4cee7","displayName":"App\\\\Mail\\\\OtpLoginMail","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Mail\\\\SendQueuedMailable","command":"O:34:\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\":15:{s:8:\\"mailable\\";O:21:\\"App\\\\Mail\\\\OtpLoginMail\\":4:{s:3:\\"otp\\";i:6225705;s:4:\\"user\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:15:\\"App\\\\Models\\\\User\\";s:2:\\"id\\";i:7;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}s:2:\\"to\\";a:1:{i:0;a:2:{s:4:\\"name\\";N;s:7:\\"address\\";s:31:\\"ahmadullahmukhlis2019@gmail.com\\";}}s:6:\\"mailer\\";s:4:\\"smtp\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:13:\\"maxExceptions\\";N;s:17:\\"shouldBeEncrypted\\";b:0;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;s:3:\\"job\\";N;}"}}',
                'attempts' => 0,
                'reserved_at' => null,
                'available_at' => 1759750097,
                'created_at' => 1759750097,
            ],
            3 => [
                'id' => 58,
                'queue' => 'default',
                'payload' => '{"uuid":"cbb11d4b-8136-458f-a614-c9e5b4c349e0","displayName":"App\\\\Mail\\\\OtpLoginMail","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Mail\\\\SendQueuedMailable","command":"O:34:\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\":15:{s:8:\\"mailable\\";O:21:\\"App\\\\Mail\\\\OtpLoginMail\\":4:{s:3:\\"otp\\";i:2523513;s:4:\\"user\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:15:\\"App\\\\Models\\\\User\\";s:2:\\"id\\";i:8;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}s:2:\\"to\\";a:1:{i:0;a:2:{s:4:\\"name\\";N;s:7:\\"address\\";s:31:\\"ahmadullahmukhlis2019@gmail.com\\";}}s:6:\\"mailer\\";s:4:\\"smtp\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:13:\\"maxExceptions\\";N;s:17:\\"shouldBeEncrypted\\";b:0;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;s:3:\\"job\\";N;}"}}',
                'attempts' => 0,
                'reserved_at' => null,
                'available_at' => 1759750114,
                'created_at' => 1759750114,
            ],
            4 => [
                'id' => 59,
                'queue' => 'default',
                'payload' => '{"uuid":"4df3af07-b8db-40c4-a299-74e8d79170be","displayName":"App\\\\Mail\\\\OtpLoginMail","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Mail\\\\SendQueuedMailable","command":"O:34:\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\":15:{s:8:\\"mailable\\";O:21:\\"App\\\\Mail\\\\OtpLoginMail\\":4:{s:3:\\"otp\\";i:4873262;s:4:\\"user\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:15:\\"App\\\\Models\\\\User\\";s:2:\\"id\\";i:9;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}s:2:\\"to\\";a:1:{i:0;a:2:{s:4:\\"name\\";N;s:7:\\"address\\";s:31:\\"ahmadullahmukhlis2019@gmail.com\\";}}s:6:\\"mailer\\";s:4:\\"smtp\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:13:\\"maxExceptions\\";N;s:17:\\"shouldBeEncrypted\\";b:0;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;s:3:\\"job\\";N;}"}}',
                'attempts' => 0,
                'reserved_at' => null,
                'available_at' => 1759750159,
                'created_at' => 1759750159,
            ],
            5 => [
                'id' => 60,
                'queue' => 'default',
                'payload' => '{"uuid":"8c836283-10a6-4dc3-80e1-d1f538b260f2","displayName":"App\\\\Mail\\\\OtpLoginMail","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Mail\\\\SendQueuedMailable","command":"O:34:\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\":15:{s:8:\\"mailable\\";O:21:\\"App\\\\Mail\\\\OtpLoginMail\\":4:{s:3:\\"otp\\";i:2792783;s:4:\\"user\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:15:\\"App\\\\Models\\\\User\\";s:2:\\"id\\";i:10;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}s:2:\\"to\\";a:1:{i:0;a:2:{s:4:\\"name\\";N;s:7:\\"address\\";s:31:\\"ahmadullahmukhlis2019@gmail.com\\";}}s:6:\\"mailer\\";s:4:\\"smtp\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:13:\\"maxExceptions\\";N;s:17:\\"shouldBeEncrypted\\";b:0;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;s:3:\\"job\\";N;}"}}',
                'attempts' => 0,
                'reserved_at' => null,
                'available_at' => 1759750270,
                'created_at' => 1759750270,
            ],
            6 => [
                'id' => 61,
                'queue' => 'default',
                'payload' => '{"uuid":"1b55ffb9-7876-452d-b16f-011443d45e01","displayName":"App\\\\Mail\\\\OtpLoginMail","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Mail\\\\SendQueuedMailable","command":"O:34:\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\":15:{s:8:\\"mailable\\";O:21:\\"App\\\\Mail\\\\OtpLoginMail\\":4:{s:3:\\"otp\\";i:3123162;s:4:\\"user\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:15:\\"App\\\\Models\\\\User\\";s:2:\\"id\\";i:11;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}s:2:\\"to\\";a:1:{i:0;a:2:{s:4:\\"name\\";N;s:7:\\"address\\";s:31:\\"ahmadullahmukhlis2019@gmail.com\\";}}s:6:\\"mailer\\";s:4:\\"smtp\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:13:\\"maxExceptions\\";N;s:17:\\"shouldBeEncrypted\\";b:0;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;s:3:\\"job\\";N;}"}}',
                'attempts' => 0,
                'reserved_at' => null,
                'available_at' => 1759750909,
                'created_at' => 1759750909,
            ],
            7 => [
                'id' => 62,
                'queue' => 'default',
                'payload' => '{"uuid":"77584ce3-1d50-4a7f-b92d-83722e4603e4","displayName":"App\\\\Mail\\\\OtpLoginMail","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Mail\\\\SendQueuedMailable","command":"O:34:\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\":15:{s:8:\\"mailable\\";O:21:\\"App\\\\Mail\\\\OtpLoginMail\\":4:{s:3:\\"otp\\";i:2347970;s:4:\\"user\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:15:\\"App\\\\Models\\\\User\\";s:2:\\"id\\";i:12;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}s:2:\\"to\\";a:1:{i:0;a:2:{s:4:\\"name\\";N;s:7:\\"address\\";s:31:\\"ahmadullahmukhlis2019@gmail.com\\";}}s:6:\\"mailer\\";s:4:\\"smtp\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:13:\\"maxExceptions\\";N;s:17:\\"shouldBeEncrypted\\";b:0;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;s:3:\\"job\\";N;}"}}',
                'attempts' => 0,
                'reserved_at' => null,
                'available_at' => 1759751019,
                'created_at' => 1759751019,
            ],
            8 => [
                'id' => 63,
                'queue' => 'default',
                'payload' => '{"uuid":"2d7d573c-4599-4dd8-8700-bdf4428bc2a3","displayName":"App\\\\Mail\\\\OtpLoginMail","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Mail\\\\SendQueuedMailable","command":"O:34:\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\":15:{s:8:\\"mailable\\";O:21:\\"App\\\\Mail\\\\OtpLoginMail\\":4:{s:3:\\"otp\\";i:5904996;s:4:\\"user\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:15:\\"App\\\\Models\\\\User\\";s:2:\\"id\\";i:13;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}s:2:\\"to\\";a:1:{i:0;a:2:{s:4:\\"name\\";N;s:7:\\"address\\";s:31:\\"ahmadullahmukhlis2019@gmail.com\\";}}s:6:\\"mailer\\";s:4:\\"smtp\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:13:\\"maxExceptions\\";N;s:17:\\"shouldBeEncrypted\\";b:0;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;s:3:\\"job\\";N;}"}}',
                'attempts' => 0,
                'reserved_at' => null,
                'available_at' => 1759751189,
                'created_at' => 1759751189,
            ],
            9 => [
                'id' => 64,
                'queue' => 'default',
                'payload' => '{"uuid":"522be527-d183-4090-b72e-d2932de365e1","displayName":"App\\\\Mail\\\\OtpLoginMail","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Mail\\\\SendQueuedMailable","command":"O:34:\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\":15:{s:8:\\"mailable\\";O:21:\\"App\\\\Mail\\\\OtpLoginMail\\":4:{s:3:\\"otp\\";i:4016665;s:4:\\"user\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:15:\\"App\\\\Models\\\\User\\";s:2:\\"id\\";i:14;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}s:2:\\"to\\";a:1:{i:0;a:2:{s:4:\\"name\\";N;s:7:\\"address\\";s:31:\\"ahmadullahmukhlis2019@gmail.com\\";}}s:6:\\"mailer\\";s:4:\\"smtp\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:13:\\"maxExceptions\\";N;s:17:\\"shouldBeEncrypted\\";b:0;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;s:3:\\"job\\";N;}"}}',
                'attempts' => 0,
                'reserved_at' => null,
                'available_at' => 1759751209,
                'created_at' => 1759751209,
            ],
            10 => [
                'id' => 65,
                'queue' => 'default',
                'payload' => '{"uuid":"a90d63af-6405-4529-ad31-8a0ca0c70f55","displayName":"App\\\\Events\\\\UserUpdatedEvent","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Broadcasting\\\\BroadcastEvent","command":"O:38:\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\":14:{s:5:\\"event\\";O:27:\\"App\\\\Events\\\\UserUpdatedEvent\\":1:{s:6:\\"result\\";a:3:{s:9:\\"is_active\\";b:1;s:7:\\"message\\";s:0:\\"\\";s:7:\\"user_id\\";i:2;}}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:7:\\"backoff\\";N;s:13:\\"maxExceptions\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;}"}}',
                'attempts' => 0,
                'reserved_at' => null,
                'available_at' => 1759752166,
                'created_at' => 1759752166,
            ],
            11 => [
                'id' => 66,
                'queue' => 'default',
                'payload' => '{"uuid":"391336e6-ec7f-4640-8bc3-fef953ce8cbe","displayName":"App\\\\Events\\\\TaskEvent","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Broadcasting\\\\BroadcastEvent","command":"O:38:\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\":14:{s:5:\\"event\\";O:20:\\"App\\\\Events\\\\TaskEvent\\":1:{s:4:\\"task\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:15:\\"App\\\\Models\\\\Task\\";s:2:\\"id\\";i:44;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:7:\\"backoff\\";N;s:13:\\"maxExceptions\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;}"}}',
                'attempts' => 0,
                'reserved_at' => null,
                'available_at' => 1759752420,
                'created_at' => 1759752420,
            ],
            12 => [
                'id' => 67,
                'queue' => 'default',
                'payload' => '{"uuid":"1b25587c-92cc-4bb9-9592-c7ed387dd0cc","displayName":"App\\\\Events\\\\TaskEvent","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Broadcasting\\\\BroadcastEvent","command":"O:38:\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\":14:{s:5:\\"event\\";O:20:\\"App\\\\Events\\\\TaskEvent\\":1:{s:4:\\"task\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:15:\\"App\\\\Models\\\\Task\\";s:2:\\"id\\";i:45;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:7:\\"backoff\\";N;s:13:\\"maxExceptions\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;}"}}',
                'attempts' => 0,
                'reserved_at' => null,
                'available_at' => 1759752479,
                'created_at' => 1759752479,
            ],
            13 => [
                'id' => 68,
                'queue' => 'default',
                'payload' => '{"uuid":"74c34552-c8f0-43b6-b5de-f4b677e9cde2","displayName":"App\\\\Events\\\\TaskEvent","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Broadcasting\\\\BroadcastEvent","command":"O:38:\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\":14:{s:5:\\"event\\";O:20:\\"App\\\\Events\\\\TaskEvent\\":1:{s:4:\\"task\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:15:\\"App\\\\Models\\\\Task\\";s:2:\\"id\\";i:46;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:7:\\"backoff\\";N;s:13:\\"maxExceptions\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;}"}}',
                'attempts' => 0,
                'reserved_at' => null,
                'available_at' => 1759752519,
                'created_at' => 1759752519,
            ],
            14 => [
                'id' => 69,
                'queue' => 'default',
                'payload' => '{"uuid":"43f29c43-7447-4868-9dc9-28cc752276e2","displayName":"App\\\\Events\\\\NotifyEvent","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Broadcasting\\\\BroadcastEvent","command":"O:38:\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\":14:{s:5:\\"event\\";O:22:\\"App\\\\Events\\\\NotifyEvent\\":2:{s:7:\\"message\\";s:29:\\"Seeding finished successfully\\";s:5:\\"color\\";s:5:\\"green\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:7:\\"backoff\\";N;s:13:\\"maxExceptions\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;}"}}',
                'attempts' => 0,
                'reserved_at' => null,
                'available_at' => 1759752614,
                'created_at' => 1759752614,
            ],
            15 => [
                'id' => 70,
                'queue' => 'default',
                'payload' => '{"uuid":"8d551c92-c455-44ff-b796-1b147f6c00f8","displayName":"App\\\\Events\\\\NotifyEvent","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Broadcasting\\\\BroadcastEvent","command":"O:38:\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\":14:{s:5:\\"event\\";O:22:\\"App\\\\Events\\\\NotifyEvent\\":2:{s:7:\\"message\\";s:21:\\"Seeding files updated\\";s:5:\\"color\\";s:5:\\"green\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:7:\\"backoff\\";N;s:13:\\"maxExceptions\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;}"}}',
                'attempts' => 0,
                'reserved_at' => null,
                'available_at' => 1759752614,
                'created_at' => 1759752614,
            ],
            16 => [
                'id' => 71,
                'queue' => 'default',
                'payload' => '{"uuid":"67217109-7e9e-4040-9a55-3c0343363d13","displayName":"App\\\\Events\\\\NotifyEvent","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Broadcasting\\\\BroadcastEvent","command":"O:38:\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\":14:{s:5:\\"event\\";O:22:\\"App\\\\Events\\\\NotifyEvent\\":2:{s:7:\\"message\\";s:29:\\"Seeding finished successfully\\";s:5:\\"color\\";s:5:\\"green\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:7:\\"backoff\\";N;s:13:\\"maxExceptions\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;}"}}',
                'attempts' => 0,
                'reserved_at' => null,
                'available_at' => 1759752689,
                'created_at' => 1759752689,
            ],
            17 => [
                'id' => 72,
                'queue' => 'default',
                'payload' => '{"uuid":"1afdb9c6-a281-4c55-8276-144fe4a24adb","displayName":"App\\\\Events\\\\NotifyEvent","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Broadcasting\\\\BroadcastEvent","command":"O:38:\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\":14:{s:5:\\"event\\";O:22:\\"App\\\\Events\\\\NotifyEvent\\":2:{s:7:\\"message\\";s:21:\\"Seeding files updated\\";s:5:\\"color\\";s:5:\\"green\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:7:\\"backoff\\";N;s:13:\\"maxExceptions\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;}"}}',
                'attempts' => 0,
                'reserved_at' => null,
                'available_at' => 1759752689,
                'created_at' => 1759752689,
            ],
        ]);

    }
}
