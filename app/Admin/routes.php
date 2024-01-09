<?php

use App\Admin\Controllers\API\V1\AdministratorApiController;
use App\Admin\Controllers\API\V1\RoomApiController;
use App\Admin\Controllers\API\V1\InventoryApiController;
use App\Admin\Controllers\BorrowRoomController;
use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');

    $router->resource('buildings', BuildingController::class);
    $router->resource('rooms', RoomController::class);
    $router->resource('inventories', InventoryController::class);
    $router->resource('borrow-rooms', BorrowRoomController::class);
    $router->get('/borrows/approved', 'BorrowRoomController@approved')->name('approved');
    $router->get('/borrows/denied', 'BorrowRoomController@denied')->name('denied');
    $router->get('/borrows/ongoing', 'BorrowRoomController@ongoing')->name('ongoing');
    $router->get('/borrows/finished', 'BorrowRoomController@finished')->name('finished');
    $router->get('/borrows/canceled', 'BorrowRoomController@canceled')->name('canceled');

    $router->get('/report/inventories', 'ReportController@report_inventories')->name('report.inventories');
    $router->get('/report/rooms', 'ReportController@report_rooms')->name('report.rooms');
    $router->get('/report/buildings', 'ReportController@report_buildings')->name('report.buildings');

    $router->redirect('/borrows/approved/{id}/edit', '/admin/borrow-rooms/{id}/edit');
    $router->redirect('/borrows/denied/{id}/edit', '/admin/borrow-rooms/{id}/edit');
    $router->redirect('/borrows/ongoing/{id}/edit', '/admin/borrow-rooms/{id}/edit');
    $router->redirect('/borrows/finished/{id}/edit', '/admin/borrow-rooms/{id}/edit');
    $router->redirect('/borrows/canceled/{id}/edit', '/admin/borrow-rooms/{id}/edit');

    $router->redirect('/borrows/approved/{id}', '/admin/borrow-rooms/{id}');
    $router->redirect('/borrows/denied/{id}', '/admin/borrow-rooms/{id}');
    $router->redirect('/borrows/ongoing/{id}', '/admin/borrow-rooms/{id}');
    $router->redirect('/borrows/finished/{id}', '/admin/borrow-rooms/{id}');
    $router->redirect('/borrows/canceled/{id}', '/admin/borrow-rooms/{id}');

    $router->group(['prefix' => 'api'], function (Router $router) {
        // AdministratorApiController
        $router->get('borrowers', [AdministratorApiController::class, 'getBorrowers']);
        $router->get('administrators', [AdministratorApiController::class, 'getAdministrators']);

        // RoomApiController
        $router->get('rooms', [RoomApiController::class, 'getRooms']);

        // InventoryApiController
        $router->get('inventories', [InventoryApiController::class, 'getInventories']);
    });
});
