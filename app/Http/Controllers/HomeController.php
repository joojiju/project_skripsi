<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Inventory;
use App\Models\BorrowRoom;
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

    public function status()
    {
        $resiValue = request('resi');

        // $status_pengajuan = optional(BorrowRoom::find($resiValue))->findOrFail($resiValue);
        $status_pengajuan = optional(BorrowRoom::withTrashed()->find($resiValue));

        return view('pages.status', compact('status_pengajuan'));
    }

    public function schedule()
    {
        // Retrieve data from BorrowRoom model with a join on the 'room' table
        $borrowRoomData = BorrowRoom::where('admin_approval_status', 1)
        ->join('rooms', 'borrow_rooms.room_id', '=', 'rooms.id')
        ->join('buildings', 'rooms.building_id', '=', 'buildings.id')
        ->get([
            'borrow_rooms.borrow_at',
            'borrow_rooms.activity',
            'rooms.name as room_name', // Assuming 'name' is the column in the 'room' table you want
            'buildings.name as building_name'
        ]);

        // Return matching results as JSON
        return response()->json($borrowRoomData);
    }


}
