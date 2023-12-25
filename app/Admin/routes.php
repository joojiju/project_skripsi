<?php

use App\Admin\Controllers\API\V1\AdministratorApiController;
use App\Admin\Controllers\API\V1\RoomApiController;
use App\Admin\Controllers\API\V1\InventoryApiController;
use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');

    $router->resource('buildings', RoomTypeController::class);
    $router->resource('rooms', RoomController::class);
    $router->resource('inventories', InventoryController::class);
    $router->resource('borrow-rooms', BorrowRoomController::class);

    $router->group(['prefix' => 'api'], function (Router $router) {
        // AdministratorApiController
        $router->get('college-students', [AdministratorApiController::class, 'getCollegeStudents']);
        $router->get('administrators', [AdministratorApiController::class, 'getAdministrators']);

        // RoomApiController
        $router->get('rooms', [RoomApiController::class, 'getRooms']);

        // InventoryApiController
        $router->get('inventories', [InventoryApiController::class, 'getInventories']);
    });
});
