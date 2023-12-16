<?php

namespace App\Admin\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomApiController extends Controller
{
    /**
     * Get all rooms
     *
     * @param  mixed $request
     * @return void
     */
    public function getRooms(Request $request)
    {
        $q = $request->get('q');

        // Get room.name with buildings.name
        return Room::join('buildings', 'rooms.building_id', '=', 'buildings.id')
            ->select('rooms.id as id', \DB::raw("CONCAT(rooms.name, ' - ', buildings.name) as text"))
            ->where('rooms.name', 'like', "%$q%")->paginate(null, ['id', 'text']);
    }
}
