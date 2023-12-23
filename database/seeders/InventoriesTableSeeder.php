<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class InventoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $inventories = array(
            0 =>
            array(
                'id' => 1,
                'name' => 'Inventaris 1',
                'type' => 'Merk A',
                'quantity' => 3,
                'status' => 0,
                'notes' => NULL,
                'room_id' => 1,
                'admin_id' => NULL,
                'created_at' => '2021-08-05 19:08:55',
                'updated_at' => '2021-08-05 19:11:17',
                'deleted_at' => NULL,
            ),
        );

        // Checking if the table already have a query
        if (is_null(\DB::table('inventories')->first()))
            \DB::table('inventories')->insert($inventories);
        else
            echo "\e[31mTable is not empty, therefore NOT ";
    }
}
