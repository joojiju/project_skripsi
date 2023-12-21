<?php

namespace App\Admin\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryApiController extends Controller
{
    /**
     * Get all rooms
     *
     * @param  mixed $request
     * @return void
     */
    public function getInventories(Request $request)
    {
        $q = $request->get('q');

        // Get inventory.name with rooms.name
        return Inventory::join('rooms', 'inventories.room_id', '=', 'rooms.id')
            ->select('inventories.id as id', \DB::raw("CONCAT(inventories.name, ' - ', rooms.name) as text"))
            ->where('inventories.name', 'like', "%$q%")->paginate(null, ['id', 'text']);
    }
}
