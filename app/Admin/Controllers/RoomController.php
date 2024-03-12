<?php

namespace App\Admin\Controllers;

use App\Enums\RoomStatus;
use App\Models\Room;
use App\Http\Controllers\Controller;
use App\Models\Building;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class RoomController extends Controller
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
            ->header('<b>RUANGAN</b>')
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
            ->header('<b>RUANGAN</b>')
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
            ->header('<b>RUANGAN</b>')
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
            ->header('<b>RUANGAN</b>')
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
        $grid = new Grid(new Room);

        $grid->id('ID');

        $grid->column('name', 'Nama');
        $grid->column('building.name', 'Gedung');
        $grid->column('max_people', 'Kapasitas');
        $grid->column('facility', 'Fasilitas');
        $grid->column('size', 'Ukuran(m<sup>2</sup>)');
        $grid->column('room_status', 'Status Ruangan')->display(function ($value) {
            $val = ['info', 'Tersedia'];
            foreach ($this->borrow_rooms as $borrow_room) {
                $admin_approval_status =    $borrow_room->admin_approval_status;
                $returned_at =              $borrow_room->returned_at ?? null;
                $processed_at =             $borrow_room->processed_at ?? null;

                    if ($admin_approval_status == 1) {
                        if ($returned_at != null)
                            $val = ['success', 'Peminjaman selesai'];
                        else if ($processed_at != null)
                            $val = ['success', 'Ruangan sedang digunakan'];
                        else
                            $val = ['success', 'Sudah disetujui'];
                    } else if ($admin_approval_status == 0)
                        $val = ['info', 'Menunggu persetujuan'];
            }

            // return 'wkwk';
            return '<span class="label-' . $val[0] . '" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;'
                . $val[1];
        });

        // Role & Permission
        if (!\Admin::user()->can('create.rooms'))
            $grid->disableCreateButton();

        $grid->actions(function ($actions) {

            // The roles with this permission will not able to see the view button in actions column.
            if (!\Admin::user()->can('edit.rooms')) {
                $actions->disableEdit();
            }
            // The roles with this permission will not able to see the show button in actions column.
            if (!\Admin::user()->can('list.rooms')) {
                $actions->disableView();
            }
            // The roles with this permission will not able to see the delete button in actions column.
            if (!\Admin::user()->can('delete.rooms')) {
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
        $show = new Show(Room::findOrFail($id));

        $show->id('ID');
        $show->field('name', 'Nama');
        $show->field('building.name', 'Gedung');
        $show->field('max_people', 'Kapasitas');
        $show->field('image', 'Gambar')->image();
        $show->field('facility', 'Fasilitas');
        $show->field('size', 'Ukuran(m<sup>2</sup>)');
        $show->field('notes', 'Catatan');
        $show->created_at(trans('admin.created_at'));
        $show->updated_at(trans('admin.updated_at'));

        // Role & Permission
        $show->panel()
            ->tools(function ($tools) {
                // The roles with this permission will not able to see the view button in actions column.
                if (!\Admin::user()->can('edit.rooms'))
                    $tools->disableEdit();

                // The roles with this permission will not able to see the show button in actions column.
                if (!\Admin::user()->can('list.rooms'))
                    $tools->disableList();

                // The roles with this permission will not able to see the delete button in actions column.
                if (!\Admin::user()->can('delete.rooms'))
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
        $form = new Form(new Room);

        if ($form->isEditing())
            $form->display('id', 'ID');

        $form->text('name', 'Nama')->rules('required');
        $form->select('building_id', 'Gedung')->rules('required')->options(function ($id) {
            return Building::all()->pluck('name', 'id');
        });
        $form->slider('max_people', 'Kapasitas')->rules('required')->options([
            'min' => 1,
            'max' => 100,
            'from' => 20,
            'postfix' => ' orang'
        ]);
        $form->image('image', 'Gambar')->rules('required|image');
        $form->textarea('facility', 'Fasilitas')->rules('required');
        $form->slider('size', 'Ukuran')->rules('required')->options([
            'min' => 1,
            'max' => 100,
            'from' => 20,
            'postfix' => ' m<sup>2</sup>'
        ]);
        $form->textarea('notes', 'Catatan');

        if ($form->isEditing()) {
            $form->display('created_at', trans('admin.created_at'));
            $form->display('updated_at', trans('admin.updated_at'));
        }

        return $form;
    }
}
