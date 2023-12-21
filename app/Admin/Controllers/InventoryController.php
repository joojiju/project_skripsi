<?php

namespace App\Admin\Controllers;

use App\Enums\InventoryStatus;
use App\Models\Inventory;
use App\Http\Controllers\Controller;
use App\Models\Room;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class InventoryController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Inventaris')
            ->description(trans('admin.list'))
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Inventaris')
            ->description(trans('admin.show'))
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Inventaris')
            ->description(trans('admin.edit'))
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Inventaris')
            ->description(trans('admin.create'))
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Inventory);

        $grid->id('ID');
        $grid->column('name', 'Nama');
        $grid->column('type', 'Tipe/Merk');
        $grid->column('quantity', 'Jumlah');
        $grid->column('room.name', 'Ruangan');
        $grid->column('inventory_status', 'Status Inventaris')->display(function ($value) {
            $val = ['info', 'Kosong'];
            foreach ($this->borrow_rooms as $borrow_room) {
                $lecturer_approval_status = $borrow_room->lecturer_approval_status;
                $admin_approval_status =    $borrow_room->admin_approval_status;
                $returned_at =              $borrow_room->returned_at ?? null;
                $processed_at =             $borrow_room->processed_at ?? null;

                if ($lecturer_approval_status == 1) {
                    if ($admin_approval_status == 1) {
                        if ($returned_at != null)
                            $val = ['success', 'Peminjaman selesai'];
                        else if ($processed_at != null)
                            $val = ['success', 'Inventaris sedang digunakan'];
                        else
                            $val = ['success', 'Sudah disetujui TU'];
                    } else if ($admin_approval_status == 0)
                        $val = ['info', 'Menunggu persetujuan TU'];
                } else if ($lecturer_approval_status == 0) {
                    $val = ['info', 'Menunggu persetujuan Dosen'];
                }
            }
            // return 'wkwk';
            return '<span class="label-' . $val[0] . '" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;'
                . $val[1];
        });

        // Role & Permission
        if (!\Admin::user()->can('create.inventories'))
            $grid->disableCreateButton();

        $grid->actions(function ($actions) {

            // The roles with this permission will not able to see the view button in actions column.
            if (!\Admin::user()->can('edit.inventories')) {
                $actions->disableEdit();
            }
            // The roles with this permission will not able to see the show button in actions column.
            if (!\Admin::user()->can('list.inventories')) {
                $actions->disableView();
            }
            // The roles with this permission will not able to see the delete button in actions column.
            if (!\Admin::user()->can('delete.inventories')) {
                $actions->disableDelete();
            }
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Inventory::findOrFail($id));

        $show->id('ID');
        $show->field('name', 'Nama');
        $show->field('type', 'Tipe/Merk');
        $show->field('room.name', 'Ruangan');
        $show->field('quantity', 'Jumlah');
        $show->field('status', 'Status')->using(InventoryStatus::asSelectArray());
        $show->field('notes', 'Catatan');
        $show->created_at(trans('admin.created_at'));
        $show->updated_at(trans('admin.updated_at'));

        // Role & Permission
        $show->panel()
            ->tools(function ($tools) {
                // The roles with this permission will not able to see the view button in actions column.
                if (!\Admin::user()->can('edit.inventories'))
                    $tools->disableEdit();

                // The roles with this permission will not able to see the show button in actions column.
                if (!\Admin::user()->can('list.inventories'))
                    $tools->disableList();

                // The roles with this permission will not able to see the delete button in actions column.
                if (!\Admin::user()->can('delete.inventories'))
                    $tools->disableDelete();
            });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Inventory);

        if ($form->isEditing())
            $form->display('id', 'ID');

        $form->text('name', 'Nama');
        $form->select('room_id', 'Ruangan')->options(function ($id) {
            return Room::all()->pluck('name', 'id');
        });
        $form->text('type', 'Tipe/Merk');
        $form->slider('quantity', 'Jumlah')->options([
            'min' => 1,
            'max' => 100,
            'from' => 20,
            'postfix' => ' buah'
        ]);
        $form->radio('status', 'Status')->options(InventoryStatus::asSelectArray())->stacked();
        $form->textarea('notes', 'Catatan');

        if ($form->isEditing()) {
            $form->display('created_at', trans('admin.created_at'));
            $form->display('updated_at', trans('admin.updated_at'));
        }

        return $form;
    }
}