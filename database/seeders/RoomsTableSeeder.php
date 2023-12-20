<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RoomsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $rooms = array(
            0 =>
            array(
                'id' => 1,
                'name' => 'Ruangan 1',
                'max_people' => 20,
                'status' => 0,
                'notes' => NULL,
                'building_id' => 1,
                'created_at' => '2021-08-05 19:08:55',
                'updated_at' => '2021-08-05 19:11:17',
                'deleted_at' => NULL,
            ),
        );

        // Checking if the table already have a query
        if (is_null(\DB::table('rooms')->first()))
            \DB::table('rooms')->insert($rooms);
        else
            echo "\e[31mTable is not empty, therefore NOT ";
    }
}
