<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities');

        $sql = file_get_contents(database_path() . '/seeders/sql/cities-1.sql');
        DB::statement($sql);
        $sql = file_get_contents(database_path() . '/seeders/sql/cities-2.sql');
        DB::statement($sql);
        $sql = file_get_contents(database_path() . '/seeders/sql/cities-3.sql');
        DB::statement($sql);
        $sql = file_get_contents(database_path() . '/seeders/sql/cities-4.sql');
        DB::statement($sql);
        $sql = file_get_contents(database_path() . '/seeders/sql/cities-5.sql');
        DB::statement($sql);
        $sql = file_get_contents(database_path() . '/seeders/sql/cities-6.sql');
        DB::statement($sql);
        $sql = file_get_contents(database_path() . '/seeders/sql/cities-7.sql');
        DB::statement($sql);
        $sql = file_get_contents(database_path() . '/seeders/sql/cities-8.sql');
        DB::statement($sql);
        $sql = file_get_contents(database_path() . '/seeders/sql/cities-9.sql');
        DB::statement($sql);
        $sql = file_get_contents(database_path() . '/seeders/sql/cities-10.sql');
        DB::statement($sql);
        $sql = file_get_contents(database_path() . '/seeders/sql/cities-11.sql');
        DB::statement($sql);
        $sql = file_get_contents(database_path() . '/seeders/sql/cities-12.sql');
        DB::statement($sql);
        $sql = file_get_contents(database_path() . '/seeders/sql/cities-13.sql');
        DB::statement($sql);
        $sql = file_get_contents(database_path() . '/seeders/sql/cities-14.sql');
        DB::statement($sql);
    }
}
