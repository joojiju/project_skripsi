<?php

namespace App\Admin\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Http\Request;
use Encore\Admin\Facades\Admin;

class AdministratorApiController extends Controller
{

    /**
     * Get all administrator where has role `peminjam`
     *
     * @param  mixed $request
     * @return void
     */
    public function getBorrowers(Request $request)
    {
        $q = $request->get('q');

        return Administrator::whereHas('roles', function ($query) {
            $query->where('slug', 'peminjam');
        })->where('name', 'like', "%$q%")->paginate(null, ['id', 'name as text']);
    }

    /**
     * Get all administrator where has role `komisi-rumah-tangga`
     *
     * @param  mixed $request
     * @return void
     */
    public function getAdministrators(Request $request)
    {
        $q = $request->get('q');

        return Administrator::whereHas('roles', function ($query) {
            $query->where('slug', 'komisi-rumah-tangga');
        })->where('name', 'like', "%$q%")->paginate(null, ['id', 'name as text']);
    }
}
