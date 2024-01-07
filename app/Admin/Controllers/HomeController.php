<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\InfoBox;
use Encore\Admin\Widgets\Box;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->title('<b>DASHBOARD</b>')
            ->description('SIPRIG')
            ->row(function (Row $row) {
                // Widget for buildings
                $row->column(3, function (Column $column) {
                    $count_buildings = \DB::table('buildings')->count();
                    $infoBox = new InfoBox('Bangunan', 'building', 'blue', route('admin.buildings.index'), $count_buildings);
                    $column->append($infoBox);
                });

                // Widget for rooms
                $row->column(3, function (Column $column) {
                    $count_rooms = \DB::table('rooms')->count();
                    $infoBox = new InfoBox('Ruangan', 'building', 'yellow', route('admin.rooms.index'), $count_rooms);
                    $column->append($infoBox);                 
                });

                // Widget for inventories
                $row->column(3, function (Column $column) {
                    $count_inventories = \DB::table('inventories')->count();
                    $infoBox = new InfoBox('Inventaris', 'suitcase', 'green', route('admin.inventories.index'), $count_inventories);
                    $column->append($infoBox);                 
                });

                // Widget for borrow rooms
                $row->column(3, function (Column $column) {
                    $count_borrow_rooms = \DB::table('borrow_rooms')->count();
                    $infoBox = new InfoBox('Peminjaman', 'calendar', 'red', route('admin.borrow-rooms.index'), $count_borrow_rooms);
                    $column->append($infoBox);
                });
            })
            ->row(function (Row $row) {
                $row->column(12, function (Column $column) {
                    $column->append($this->admin_user_info());
                });
            });
    }

    public function admin_user_info()
    {
        $admin_user = \Admin::user();
        $data['admin_user_first_name'] = ucfirst(strtolower(explode(' ', $admin_user->name)[0]));
        $data['greetings'] = $this->Greetings(Carbon::now()->format('H'));
        $data['is_new_admin_user'] = false;

        if ( // Check user if same password with username
            Hash::check($admin_user->username, $admin_user->password)
            || $admin_user->created_at == $admin_user->updated_at
        ) {
            $data['is_new_admin_user'] = true;
        }

        return view('dashboard.admin_user_info', compact('data'));
    }

    public function Greetings($hours)
    {
        if ($hours >= 0 && $hours <= 11)
            return "Pagi";
        else if ($hours >= 12 && $hours <= 14)
            return "Siang";
        else if ($hours >= 15 && $hours <= 17)
            return "Sore";
        else if ($hours >= 17 && $hours <= 18)
            return "Petang";
        else if ($hours >= 19 && $hours <= 23)
            return "Malam";
    }

    
}
