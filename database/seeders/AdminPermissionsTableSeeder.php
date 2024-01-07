<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminPermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $admin_permissions = array(
            0 =>
            array(
                'id' => 1,
                'name' => 'All permission',
                'slug' => '*',
                'http_method' => '',
                'http_path' => '*',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 =>
            array(
                'id' => 2,
                'name' => 'Dashboard',
                'slug' => 'dashboard',
                'http_method' => 'GET',
                'http_path' => '/',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 =>
            array(
                'id' => 3,
                'name' => 'Login',
                'slug' => 'auth.login',
                'http_method' => '',
                'http_path' => '/auth/login
                                /auth/logout',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 =>
            array(
                'id' => 4,
                'name' => 'User setting',
                'slug' => 'auth.setting',
                'http_method' => 'GET,PUT',
                'http_path' => '/auth/setting',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 =>
            array(
                'id' => 5,
                'name' => 'Auth management',
                'slug' => 'auth.management',
                'http_method' => '',
                'http_path' => '/auth/roles
                                /auth/permissions
                                /auth/menu
                                /auth/logs',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 =>
            array(
                'id' => 6,
                'name' => 'Admin helpers',
                'slug' => 'ext.helpers',
                'http_method' => '',
                'http_path' => '/helpers/*',
                'created_at' => '2021-08-04 22:20:58',
                'updated_at' => '2021-08-04 22:20:58',
            ),
            6 =>
            array(
                'id' => 7,
                'name' => 'List Room Types',
                'slug' => 'list.buildings',
                'http_method' => 'GET',
                'http_path' => '/buildings*',
                'created_at' => '2021-08-12 01:32:56',
                'updated_at' => '2021-08-12 02:08:23',
            ),
            7 =>
            array(
                'id' => 8,
                'name' => 'Create Buildings',
                'slug' => 'create.buildings',
                'http_method' => 'POST',
                'http_path' => '/buildings*',
                'created_at' => '2021-08-12 01:47:16',
                'updated_at' => '2021-08-12 02:09:02',
            ),
            8 =>
            array(
                'id' => 9,
                'name' => 'Edit Buildings',
                'slug' => 'edit.buildings',
                'http_method' => 'PUT',
                'http_path' => '/buildings/*',
                'created_at' => '2021-08-12 01:54:49',
                'updated_at' => '2021-08-12 02:09:47',
            ),
            9 =>
            array(
                'id' => 10,
                'name' => 'Delete Buildings',
                'slug' => 'delete.buildings',
                'http_method' => 'DELETE',
                'http_path' => '/buildings/*',
                'created_at' => '2021-08-12 02:01:03',
                'updated_at' => '2021-08-12 02:01:03',
            ),
            10 =>
            array(
                'id' => 11,
                'name' => 'List Rooms',
                'slug' => 'list.rooms',
                'http_method' => 'GET',
                'http_path' => '/rooms*',
                'created_at' => '2021-08-12 02:11:31',
                'updated_at' => '2021-08-12 02:11:31',
            ),
            11 =>
            array(
                'id' => 12,
                'name' => 'Create Room',
                'slug' => 'create.rooms',
                'http_method' => 'POST',
                'http_path' => '/rooms*',
                'created_at' => '2021-08-12 02:11:55',
                'updated_at' => '2021-08-12 02:11:55',
            ),
            12 =>
            array(
                'id' => 13,
                'name' => 'Edit Room',
                'slug' => 'edit.rooms',
                'http_method' => 'PUT',
                'http_path' => '/rooms/*',
                'created_at' => '2021-08-12 02:12:23',
                'updated_at' => '2021-08-12 02:12:23',
            ),
            13 =>
            array(
                'id' => 14,
                'name' => 'Delete Room',
                'slug' => 'delete.rooms',
                'http_method' => 'DELETE',
                'http_path' => '/rooms/*',
                'created_at' => '2021-08-12 02:12:40',
                'updated_at' => '2021-08-12 02:12:40',
            ),
            14 =>
            array(
                'id' => 15,
                'name' => 'List Borrow Rooms',
                'slug' => 'list.borrow_rooms',
                'http_method' => 'GET',
                'http_path' => '/borrow-rooms*',
                'created_at' => '2021-08-12 02:13:24',
                'updated_at' => '2021-08-12 02:13:24',
            ),
            15 =>
            array(
                'id' => 16,
                'name' => 'Create Borrow Room',
                'slug' => 'create.borrow_rooms',
                'http_method' => 'POST',
                'http_path' => '/borrow-rooms*',
                'created_at' => '2021-08-12 02:13:49',
                'updated_at' => '2021-08-12 02:13:49',
            ),
            16 =>
            array(
                'id' => 17,
                'name' => 'Edit Borrow Room',
                'slug' => 'edit.borrow_rooms',
                'http_method' => 'PUT',
                'http_path' => '/borrow-rooms/*',
                'created_at' => '2021-08-12 02:14:12',
                'updated_at' => '2021-08-12 02:14:12',
            ),
            17 =>
            array(
                'id' => 18,
                'name' => 'Delete Borrow Rooms',
                'slug' => 'delete.borrow_rooms',
                'http_method' => 'DELETE',
                'http_path' => '/borrow-rooms/*',
                'created_at' => '2021-08-12 02:14:35',
                'updated_at' => '2021-08-12 02:14:35',
            ),
            18 =>
            array(
                'id' => 19,
                'name' => 'List Inventories',
                'slug' => 'list.inventories',
                'http_method' => 'GET',
                'http_path' => '/inventories*',
                'created_at' => '2021-08-12 02:11:31',
                'updated_at' => '2021-08-12 02:11:31',
            ),
            19 =>
            array(
                'id' => 20,
                'name' => 'Create Inventories',
                'slug' => 'create.inventories',
                'http_method' => 'POST',
                'http_path' => '/inventories*',
                'created_at' => '2021-08-12 02:11:55',
                'updated_at' => '2021-08-12 02:11:55',
            ),
            20 =>
            array(
                'id' => 21,
                'name' => 'Edit Inventories',
                'slug' => 'edit.inventories',
                'http_method' => 'PUT',
                'http_path' => '/inventories/*',
                'created_at' => '2021-08-12 02:12:23',
                'updated_at' => '2021-08-12 02:12:23',
            ),
            21 =>
            array(
                'id' => 22,
                'name' => 'Delete Inventories',
                'slug' => 'delete.inventories',
                'http_method' => 'DELETE',
                'http_path' => '/inventories/*',
                'created_at' => '2021-08-12 02:12:40',
                'updated_at' => '2021-08-12 02:12:40',
            ),
            22 =>
            array(
                'id' => 23,
                'name' => 'Pengajuan Disetujui',
                'slug' => 'approved.borrows',
                'http_method' => 'GET',
                'http_path' => '/borrows/approved*',
                'created_at' => '2021-08-12 02:12:40',
                'updated_at' => '2021-08-12 02:12:40',
            ),
            23 =>
            array(
                'id' => 24,
                'name' => 'Pengajuan Ditolak',
                'slug' => 'denied.borrows',
                'http_method' => 'GET',
                'http_path' => '/borrows/denied*',
                'created_at' => '2021-08-12 02:12:40',
                'updated_at' => '2021-08-12 02:12:40',
            ),
            24 =>
            array(
                'id' => 25,
                'name' => 'Pengajuan Berjalan',
                'slug' => 'ongoing.borrows',
                'http_method' => 'GET',
                'http_path' => '/borrows/ongoing*',
                'created_at' => '2021-08-12 02:12:40',
                'updated_at' => '2021-08-12 02:12:40',
            ),
            25 =>
            array(
                'id' => 26,
                'name' => 'Pengajuan Selesai',
                'slug' => 'finished.borrows',
                'http_method' => 'GET',
                'http_path' => '/borrows/finished*',
                'created_at' => '2021-08-12 02:12:40',
                'updated_at' => '2021-08-12 02:12:40',
            ),
            26 =>
            array(
                'id' => 27,
                'name' => 'Pengajuan Batal',
                'slug' => 'canceled.borrows',
                'http_method' => 'GET',
                'http_path' => '/borrows/canceled*',
                'created_at' => '2021-08-12 02:12:40',
                'updated_at' => '2021-08-12 02:12:40',
            ),
            27 =>
            array(
                'id' => 28,
                'name' => 'Laporan Peminjaman Ruangan',
                'slug' => 'rooms.report',
                'http_method' => 'GET',
                'http_path' => '/report/rooms*',
                'created_at' => '2021-08-12 02:12:40',
                'updated_at' => '2021-08-12 02:12:40',
            ),
            28 =>
            array(
                'id' => 29,
                'name' => 'Laporan Peminjaman Inventaris',
                'slug' => 'inventories.report',
                'http_method' => 'GET',
                'http_path' => '/report/inventories*',
                'created_at' => '2021-08-12 02:12:40',
                'updated_at' => '2021-08-12 02:12:40',
            ),
            29 =>
            array(
                'id' => 30,
                'name' => 'Laporan Peminjaman Gedung',
                'slug' => 'buildings.report',
                'http_method' => 'GET',
                'http_path' => '/report/buildings*',
                'created_at' => '2021-08-12 02:12:40',
                'updated_at' => '2021-08-12 02:12:40',
            ),
        );

        // Checking if the table already have a query
        if (is_null(\DB::table('admin_permissions')->first()))
            \DB::table('admin_permissions')->insert($admin_permissions);
        else
            echo "\e[31mTable is not empty, therefore NOT ";
    }
}
