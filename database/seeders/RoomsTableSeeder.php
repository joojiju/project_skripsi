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
                'image' => 'https://independennusantara.com/asset/images/IMG-20211225-WA0072.jpg',
                'facility' => 'AC, LCD, Whiteboard, Meja, Kursi',
                'size' => 9,
                'notes' => NULL,
                'building_id' => 1,
                'created_at' => '2021-08-05 19:08:55',
                'updated_at' => '2021-08-05 19:11:17',
                'deleted_at' => NULL,
            ),
            1 =>
            array(
                'id' => 2,
                'name' => 'Ruangan 2',
                'max_people' => 20,
                'image' => 'https://independennusantara.com/asset/images/IMG-20211225-WA0072.jpg',
                'facility' => 'AC, LCD, Whiteboard, Meja, Kursi',
                'size' => 9,
                'notes' => NULL,
                'building_id' => 1,
                'created_at' => '2021-08-05 19:08:55',
                'updated_at' => '2021-08-05 19:11:17',
                'deleted_at' => NULL,
            ),
            2 =>
            array(
                'id' => 3,
                'name' => 'Ruangan 3',
                'max_people' => 20,
                'image' => 'https://independennusantara.com/asset/images/IMG-20211225-WA0072.jpg',
                'facility' => 'AC, LCD, Whiteboard, Meja, Kursi',
                'size' => 9,
                'notes' => NULL,
                'building_id' => 1,
                'created_at' => '2021-08-05 19:08:55',
                'updated_at' => '2021-08-05 19:11:17',
                'deleted_at' => NULL,
            ),
            3 =>
            array(
                'id' => 4,
                'name' => 'Ruangan 4',
                'max_people' => 20,
                'image' => 'https://independennusantara.com/asset/images/IMG-20211225-WA0072.jpg',
                'facility' => 'AC, LCD, Whiteboard, Meja, Kursi',
                'size' => 9,
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
