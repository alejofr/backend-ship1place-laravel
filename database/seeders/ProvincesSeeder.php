<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvincesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('provinces');

        $sql = file_get_contents(database_path() . '/seeders/sql/provinces-1.sql');
        DB::statement($sql);
        $sql = file_get_contents(database_path() . '/seeders/sql/provinces-2.sql');
        DB::statement($sql);
        $sql = file_get_contents(database_path() . '/seeders/sql/provinces-3.sql');
        DB::statement($sql);
        $sql = file_get_contents(database_path() . '/seeders/sql/provinces-4.sql');
        DB::statement($sql);
    }
}
