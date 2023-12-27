<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminMenuTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $admin_menu = array(
            0 =>
            array(
                'id' => 1,
                'parent_id' => 0,
                'order' => 1,
                'title' => 'Dasboard',
                'icon' => 'fa-dashboard',
                'uri' => '/',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 =>
            array(
                'id' => 2,
                'parent_id' => 0,
                'order' => 14,
                'title' => 'Admin',
                'icon' => 'fa-tasks',
                'uri' => '',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2021-08-12 01:34:07',
            ),
            2 =>
            array(
                'id' => 3,
                'parent_id' => 2,
                'order' => 15,
                'title' => 'Users',
                'icon' => 'fa-users',
                'uri' => 'auth/users',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2021-08-12 01:34:07',
            ),
            3 =>
            array(
                'id' => 4,
                'parent_id' => 2,
                'order' => 16,
                'title' => 'Roles',
                'icon' => 'fa-user',
                'uri' => 'auth/roles',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2021-08-12 01:34:07',
            ),
            4 =>
            array(
                'id' => 5,
                'parent_id' => 2,
                'order' => 17,
                'title' => 'Permission',
                'icon' => 'fa-ban',
                'uri' => 'auth/permissions',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2021-08-12 01:34:07',
            ),
            5 =>
            array(
                'id' => 6,
                'parent_id' => 2,
                'order' => 18,
                'title' => 'Menu',
                'icon' => 'fa-bars',
                'uri' => 'auth/menu',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2021-08-12 01:34:07',
            ),
            6 =>
            array(
                'id' => 7,
                'parent_id' => 2,
                'order' => 19,
                'title' => 'Operation log',
                'icon' => 'fa-history',
                'uri' => 'auth/logs',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2021-08-12 01:34:07',
            ),
            7 =>
            array(
                'id' => 8,
                'parent_id' => 0,
                'order' => 20,
                'title' => 'Helpers',
                'icon' => 'fa-gears',
                'uri' => '',
                'permission' => NULL,
                'created_at' => '2021-08-04 22:20:58',
                'updated_at' => '2021-08-12 01:34:07',
            ),
            8 =>
            array(
                'id' => 9,
                'parent_id' => 8,
                'order' => 21,
                'title' => 'Scaffold',
                'icon' => 'fa-keyboard-o',
                'uri' => 'helpers/scaffold',
                'permission' => NULL,
                'created_at' => '2021-08-04 22:20:58',
                'updated_at' => '2021-08-12 01:34:07',
            ),
            9 =>
            array(
                'id' => 10,
                'parent_id' => 8,
                'order' => 22,
                'title' => 'Database terminal',
                'icon' => 'fa-database',
                'uri' => 'helpers/terminal/database',
                'permission' => NULL,
                'created_at' => '2021-08-04 22:20:58',
                'updated_at' => '2021-08-12 01:34:07',
            ),
            10 =>
            array(
                'id' => 11,
                'parent_id' => 8,
                'order' => 23,
                'title' => 'Laravel artisan',
                'icon' => 'fa-terminal',
                'uri' => 'helpers/terminal/artisan',
                'permission' => NULL,
                'created_at' => '2021-08-04 22:20:58',
                'updated_at' => '2021-08-12 01:34:07',
            ),
            11 =>
            array(
                'id' => 12,
                'parent_id' => 8,
                'order' => 24,
                'title' => 'Routes',
                'icon' => 'fa-list-alt',
                'uri' => 'helpers/routes',
                'permission' => NULL,
                'created_at' => '2021-08-04 22:20:58',
                'updated_at' => '2021-08-12 01:34:07',
            ),
            12 =>
            array(
                'id' => 13,
                'parent_id' => 0,
                'order' => 2,
                'title' => 'Verifikasi Pengajuan',
                'icon' => 'fa-calendar',
                'uri' => '',
                'permission' => 'list.borrow_rooms',
                'created_at' => '2021-08-04 22:22:30',
                'updated_at' => '2021-08-12 02:18:08',
            ),
            13 =>
            array(
                'id' => 14,
                'parent_id' => 13,
                'order' => 3,
                'title' => 'Pengajuan Masuk',
                'icon' => 'fa-calendar',
                'uri' => 'borrow-rooms',
                'permission' => 'list.borrow_rooms',
                'created_at' => '2021-08-04 22:22:30',
                'updated_at' => '2021-08-12 02:18:08',
            ),
            14 =>
            array(
                'id' => 15,
                'parent_id' => 13,
                'order' => 4,
                'title' => 'Pengajuan Diterima',
                'icon' => 'fa-calendar',
                'uri' => 'borrow-rooms',
                'permission' => 'list.borrow_rooms',
                'created_at' => '2021-08-04 22:22:30',
                'updated_at' => '2021-08-12 02:18:08',
            ),
            15 =>
            array(
                'id' => 16,
                'parent_id' => 13,
                'order' => 5,
                'title' => 'Pengajuan Ditolak',
                'icon' => 'fa-calendar',
                'uri' => 'borrow-rooms',
                'permission' => 'list.borrow_rooms',
                'created_at' => '2021-08-04 22:22:30',
                'updated_at' => '2021-08-12 02:18:08',
            ),
            16 =>
            array(
                'id' => 17,
                'parent_id' => 0,
                'order' => 6,
                'title' => 'Daftar Peminjaman',
                'icon' => 'fa-calendar',
                'uri' => '',
                'permission' => 'list.borrow_rooms',
                'created_at' => '2021-08-04 22:22:30',
                'updated_at' => '2021-08-12 02:18:08',
            ),
            17 =>
            array(
                'id' => 18,
                'parent_id' => 17,
                'order' => 7,
                'title' => 'Peminjaman Berjalan',
                'icon' => 'fa-calendar',
                'uri' => 'borrow-rooms',
                'permission' => 'list.borrow_rooms',
                'created_at' => '2021-08-04 22:22:30',
                'updated_at' => '2021-08-12 02:18:08',
            ),
            18 =>
            array(
                'id' => 19,
                'parent_id' => 17,
                'order' => 8,
                'title' => 'Peminjaman Selesai',
                'icon' => 'fa-calendar',
                'uri' => 'borrow-rooms',
                'permission' => 'list.borrow_rooms',
                'created_at' => '2021-08-04 22:22:30',
                'updated_at' => '2021-08-12 02:18:08',
            ),
            19 =>
            array(
                'id' => 20,
                'parent_id' => 17,
                'order' => 9,
                'title' => 'Peminjaman Batal',
                'icon' => 'fa-calendar',
                'uri' => 'borrow-rooms',
                'permission' => 'list.borrow_rooms',
                'created_at' => '2021-08-04 22:22:30',
                'updated_at' => '2021-08-12 02:18:08',
            ),
            20 =>
            array(
                'id' => 21,
                'parent_id' => 0,
                'order' => 10,
                'title' => 'Gedung',
                'icon' => 'fa-building',
                'uri' => 'buildings',
                'permission' => 'list.buildings',
                'created_at' => '2021-08-04 22:21:35',
                'updated_at' => '2021-08-12 02:18:40',
            ),
            21 =>
            array(
                'id' => 22,
                'parent_id' => 0,
                'order' => 11,
                'title' => 'Ruangan',
                'icon' => 'fa-building',
                'uri' => 'rooms',
                'permission' => 'list.rooms',
                'created_at' => '2021-08-04 22:22:06',
                'updated_at' => '2021-08-12 02:18:21',
            ),
            22 =>
            array(
                'id' => 23,
                'parent_id' => 0,
                'order' => 12,
                'title' => 'Inventaris',
                'icon' => 'fa-suitcase',
                'uri' => 'inventories',
                'permission' => 'list.rooms',
                'created_at' => '2021-08-04 22:22:06',
                'updated_at' => '2021-08-12 02:18:21',
            ),
            23 =>
            array(
                'id' => 24,
                'parent_id' => 0,
                'order' => 13,
                'title' => 'Laporan',
                'icon' => 'fa-file',
                'uri' => 'inventories',
                'permission' => 'list.rooms',
                'created_at' => '2021-08-04 22:22:06',
                'updated_at' => '2021-08-12 02:18:21',
            ),
        );

        // Checking if the table already have a query
        if (is_null(\DB::table('admin_menu')->first()))
            \DB::table('admin_menu')->insert($admin_menu);
        else
            echo "\e[31mTable is not empty, therefore NOT ";
    }
}
