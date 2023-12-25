<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Inventory;
use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data['rooms'] = Room::with('building')->get();
        $data['inventories'] = Inventory::with('room')->get();

        return view('index', compact('data'));
    }

    public function rooms()
    {
        $data['rooms'] = Room::with('building')->get();

        return view('pages.rooms', compact('data'));
    }
}
