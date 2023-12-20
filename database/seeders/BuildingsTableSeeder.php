<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BuildingsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $buildings = array(
            0 =>
            array(
                'id' => 1,
                'name' => 'Gedung 1',
                'is_active' => 1,
                'created_at' => '2021-08-04 22:52:24',
                'updated_at' => '2021-08-04 22:52:24',
            ),
        );

        // Checking if the table already have a query
        if (is_null(\DB::table('buildings')->first()))
            \DB::table('buildings')->insert($buildings);
        else
            echo "\e[31mTable is not empty, therefore NOT ";
    }
}
