<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BorrowRoom;
use App\Models\Inventory;
use App\Models\Building;
use Carbon\Carbon;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Form\Field;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ReportController extends Controller
{
    use HasResourceActions;

     /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function report_inventories(Content $content)
    {
        return $content
            ->header('<b>LAPORAN PEMINJAMAN INVENTARIS</b>')
            ->description(trans('admin.list'))
            ->body($this->grid_inventories());
    }

    protected function grid_inventories()
    {
        $grid = new Grid(new BorrowRoom);

        $grid->id('ID Peminjaman');
        $grid->column('inventory_name', 'Inventaris')->display(function () {
            // Decode the JSON array and fetch inventory names
            $inventoryIds = $this->inventory_id ?? [];

            // Fetch inventory names using the relationship
            $inventoryNames = Inventory::whereIn('id', $inventoryIds)->pluck('name')->toArray();

            // Convert the array of names to a comma-separated string
            return implode(', ', $inventoryNames);
        });
        $grid->column('borrow_at', 'Mulai Pinjam')->display(function ($borrow_at) {
            return Carbon::parse($borrow_at)->format('d M Y H:i');
        });
        $grid->column('until_at', 'Lama Pinjam')->display(function ($title, $column) {
            $borrow_at = Carbon::parse($this->borrow_at);
            $until_at = Carbon::parse($title);

            return $until_at->diffForHumans($borrow_at);
        });
        $grid->column('status', 'Status')->display(function ($title, $column) {
            $admin_approval_status =    $this->admin_approval_status;
            $returned_at =              $this->returned_at ?? null;
            $processed_at =             $this->processed_at ?? null;
                if ($admin_approval_status == 1) {
                    if ($returned_at != null)
                        $val = ['success', 'Peminjaman selesai'];
                    else if ($processed_at != null)
                        $val = ['success', 'Ruangan sedang digunakan'];
                        else
                            $val = ['success', 'Sudah disetujui']; }
                    else if ($admin_approval_status == 0)
                        $val = ['info', 'Menunggu persetujuan'];
                        else
                            $val = ['danger', 'Ditolak'];

            return '<span class="label-' . $val[0] . '" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;'
                . $val[1];
        });
        $grid->column('price', 'Persembahan')->display(function ($price) {
            return 'Rp. ' . number_format($price, 0, ',', '.');
        });

        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableEdit();
            $actions->disableView();
        });

        return $grid;
    }

     /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function report_rooms(Content $content)
    {
        return $content
            ->header('<b>LAPORAN PEMINJAMAN RUANGAN</b>')
            ->description(trans('admin.list'))
            ->body($this->grid_rooms());
    }

    protected function grid_rooms()
    {
        $grid = new Grid(new BorrowRoom);

        $grid->id('ID Peminjaman');
        $grid->column('room.name', 'Ruangan');
        $grid->column('borrow_at', 'Mulai Pinjam')->display(function ($borrow_at) {
            return Carbon::parse($borrow_at)->format('d M Y H:i');
        });
        $grid->column('until_at', 'Lama Pinjam')->display(function ($title, $column) {
            $borrow_at = Carbon::parse($this->borrow_at);
            $until_at = Carbon::parse($title);

            return $until_at->diffForHumans($borrow_at);
        });
        $grid->column('status', 'Status')->display(function ($title, $column) {
            $admin_approval_status =    $this->admin_approval_status;
            $returned_at =              $this->returned_at ?? null;
            $processed_at =             $this->processed_at ?? null;
                if ($admin_approval_status == 1) {
                    if ($returned_at != null)
                        $val = ['success', 'Peminjaman selesai'];
                    else if ($processed_at != null)
                        $val = ['success', 'Ruangan sedang digunakan'];
                        else
                            $val = ['success', 'Sudah disetujui']; }
                    else if ($admin_approval_status == 0)
                        $val = ['info', 'Menunggu persetujuan'];
                        else
                            $val = ['danger', 'Ditolak'];

            return '<span class="label-' . $val[0] . '" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;'
                . $val[1];
        });
        $grid->column('price', 'Persembahan')->display(function ($price) {
            return 'Rp. ' . number_format($price, 0, ',', '.');
        });

        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableEdit();
            $actions->disableView();
        });

        return $grid;
    }

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function report_buildings(Content $content)
    {
        return $content
            ->header('<b>LAPORAN PEMINJAMAN GEDUNG</b>')
            ->description(trans('admin.list'))
            ->body($this->grid_buildings());
    }

    protected function grid_buildings()
    {
        $grid = new Grid(new BorrowRoom);

        $grid->id('ID Peminjaman');
        $grid->column('room_id', 'Gedung')->display(function(){
            $room_id = $this->room_id;

            // Fetch room names using the relationship
            $building = Building::where('id', $room_id)->pluck('name');
            return $building[0];
        });
        $grid->column('borrow_at', 'Mulai Pinjam')->display(function ($borrow_at) {
            return Carbon::parse($borrow_at)->format('d M Y H:i');
        });
        $grid->column('until_at', 'Lama Pinjam')->display(function ($title, $column) {
            $borrow_at = Carbon::parse($this->borrow_at);
            $until_at = Carbon::parse($title);

            return $until_at->diffForHumans($borrow_at);
        });
        $grid->column('status', 'Status')->display(function ($title, $column) {
            $admin_approval_status =    $this->admin_approval_status;
            $returned_at =              $this->returned_at ?? null;
            $processed_at =             $this->processed_at ?? null;
                if ($admin_approval_status == 1) {
                    if ($returned_at != null)
                        $val = ['success', 'Peminjaman selesai'];
                    else if ($processed_at != null)
                        $val = ['success', 'Ruangan sedang digunakan'];
                        else
                            $val = ['success', 'Sudah disetujui']; }
                    else if ($admin_approval_status == 0)
                        $val = ['info', 'Menunggu persetujuan'];
                        else
                            $val = ['danger', 'Ditolak'];

            return '<span class="label-' . $val[0] . '" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;'
                . $val[1];
        });
        $grid->column('price', 'Persembahan')->display(function ($price) {
            return 'Rp. ' . number_format($price, 0, ',', '.');
        });

        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableEdit();
            $actions->disableView();
        });

        return $grid;
    }

}
