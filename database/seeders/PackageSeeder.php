<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('packages')->insert([
            [
                'name' => 'free',
                'sessions_per_day' => 2,
                'responses_per_session' => 20,
            ],
            [
                'name' => 'premium',
                'sessions_per_day' => 10,
                'responses_per_session' => 20,
            ],
            [
                'name' => 'guest',
                'sessions_per_day' => 2,
                'responses_per_session' => 3,
            ],
        ]);
    }
}
