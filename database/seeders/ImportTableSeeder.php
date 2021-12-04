<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ImportTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = public_path('data.sql');
          
        $db = [
            'username' => env('txexzldjlxfqlm'),
            'password' => env('d196ca3a2c0692b5913a4e44e4df0bf6f1e46d33324e52c87d1f8fa62a1e4b7c'),
            'host' => env('ec2-176-34-105-15.eu-west-1.compute.amazonaws.com'),
            'database' => env('d37t7rfil4a0mg')
        ];
  
        exec("mysql --user={$db['username']} --password={$db['password']} --host={$db['host']} --database {$db['database']} < $sql");
  
        Log::info('SQL Import Done');
    }
}
