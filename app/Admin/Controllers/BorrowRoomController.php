<?php

namespace App\Admin\Controllers;

use App\Enums\ApprovalStatus;
use App\Models\BorrowRoom;
use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Inventory;
use Carbon\Carbon;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Form\Field;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class BorrowRoomController extends Controller
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
            ->header('<b>PENGAJUAN MASUK</b>')
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
            ->header('<b>PEMINJAMAN</b>')
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
            ->header('<b>PEMINJAMAN</b>')
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
            ->header('<b>PEMINJAMAN</b>')
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
        $grid = new Grid(new BorrowRoom);

        $admin_user = \Admin::user();
        // Show query only related to roles
        if ($admin_user->isRole('peminjam'))
        $grid->model()->where('borrower_id', $admin_user->id);
        $grid->model()->where('admin_approval_status', null);

        $grid->id('ID');
        $grid->column('full_name', 'Peminjam');
        $grid->column('borrower_status', 'Status Peminjam');
        $grid->column('email', 'Email');
        $grid->column('phone_number', 'Nomor Telepon');
        $grid->column('activity', 'Kegiatan');
        $grid->column('room.name', 'Ruangan');
        // Access JSON data using the `->` notation

        $grid->column('inventory_name', 'Inventory')->display(function () {
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

        // Role & Permission
        if (!\Admin::user()->can('create.borrow_rooms'))
            $grid->disableCreateButton();

        $grid->actions(function ($actions) {

            // The roles with this permission will not able to see the view button in actions column.
            if (!\Admin::user()->can('edit.borrow_rooms')) {
                $actions->disableEdit();
            }
            // The roles with this permission will not able to see the show button in actions column.
            if (!\Admin::user()->can('list.borrow_rooms')) {
                $actions->disableView();
            }
            // The roles with this permission will not able to see the delete button in actions column.
            if (!\Admin::user()->can('delete.borrow_rooms')) {
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
        $show = new Show(BorrowRoom::findOrFail($id));

        $show->field('full_name', 'Peminjam');
        $show->field('borrower_status', 'Status Peminjam');
        $show->field('email', 'Email');
        $show->field('phone_number', 'Nomor Telepon');
        $show->field('activity', 'Kegiatan');
        $show->field('room.name', 'Ruangan');
        $show->field('inventory_name', 'Inventory')->display(function () {
            // Decode the JSON array and fetch inventory names
            $inventoryIds = $this->inventory_id ?? [];

            // Fetch inventory names using the relationship
            $inventoryNames = Inventory::whereIn('id', $inventoryIds)->pluck('name')->toArray();

            // Convert the array of names to a comma-separated string
            return implode(', ', $inventoryNames);
        });
        $show->field('borrow_at', 'Mulai Pinjam');
        $show->field('until_at', 'Selesai Pinjam');
        $show->field('admin.name', ' Komisi Rumah Tangga');
        $show->field('admin_approval_status', 'Status Persetujuan Komisi Rumah Tangga')->using(ApprovalStatus::asSelectArray());;
        $show->field('processed_at', 'Kunci Diambil Pada');
        $show->field('returned_at', 'Diselesaikan Pada');
        $show->field('notes', 'Catatan');
        $show->field('payment_at', 'Tanggal Pembayaran');
        $show->field('receipt', 'Bukti Pembayaran')->image();
        $show->field('price', 'Jumlah Pembayaran')->as(function ($payment_amount) {
            return 'Rp ' . number_format($payment_amount, 0, ',', '.');
        });
        $show->created_at(trans('admin.created_at'));
        $show->updated_at(trans('admin.updated_at'));

        // Role & Permission
        $show->panel()
            ->tools(function ($tools) {
                // The roles with this permission will not able to see the view button in actions column.
                if (!\Admin::user()->can('edit.borrow_rooms'))
                    $tools->disableEdit();

                // The roles with this permission will not able to see the show button in actions column.
                if (!\Admin::user()->can('list.borrow_rooms'))
                    $tools->disableList();

                // The roles with this permission will not able to see the delete button in actions column.
                if (!\Admin::user()->can('delete.borrow_rooms'))
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
        $form = new Form(new BorrowRoom);
        $admin_user = \Admin::user();
        $isKomisirumahtangga = $admin_user->isRole('komisi-rumah-tangga');

        if ($form->isEditing())
        $form->display('id', 'ID');
        // Peminjam Form
        if ($isKomisirumahtangga) {
            $form->text('full_name', 'Peminjam')->rules('required');
            $form->display('borrower_status', 'Status Peminjam');
            $form->display('email', 'Email');
            $form->display('phone_number', 'Nomor Telepon');
            $form->text('activity', 'Kegiatan')->rules('required');
            $form->select('room_id', 'Ruangan')->rules('required')->options(function ($id) {
                return Room::all()->pluck('name', 'id');
            });
            $form->multipleSelect('inventory_id', 'Inventaris')->rules('required')->options(function ($id) {
                return Inventory::all()->pluck('name', 'id');
            });
            $form->datetime('borrow_at', 'Mulai Pinjam')->format('YYYY-MM-DD HH:mm');
            $form->datetime('until_at', 'Selesai Pinjam')->format('YYYY-MM-DD HH:mm');
            $form->display('borrow_at', 'Lama Pinjam')->with(function () {
                $borrow_at = Carbon::parse($this->borrow_at);
                $until_at = Carbon::parse($this->until_at);
                $count_days = $borrow_at->diffInDays($until_at) + 1;

                if ($count_days == 1)
                    return $count_days . ' hari (' . $until_at->format('d M Y') . ')';
                else
                    return $count_days . ' hari (' . $borrow_at->format('d M Y') . ' s/d ' . $until_at->format('d M Y') . ')';
            });
        } else {
            $form->display('full_name', 'Peminjam');
            $form->select('room_id', 'Ruangan')->rules('required')->options(function ($id) {
                $room = Room::find($id);
                if ($room)
                    return [$room->id => $room->name];
            })->ajax('/admin/api/rooms');
            $form->datetime('borrow_at', 'Mulai Pinjam')->format('YYYY-MM-DD HH:mm');
            $form->datetime('until_at', 'Selesai Pinjam')->format('YYYY-MM-DD HH:mm');
        }

        // BATAS

        if ($isKomisirumahtangga) {
            $form->display('created_at', 'Diajukan pada')->with(function () {
                return Carbon::parse($this->created_at)->format('d M Y');
            });
            $form->radio('admin_approval_status', 'Status Persetujuan')->options(ApprovalStatus::asSelectArray());
            $form->select('admin_id', 'Komisi Rumah Tangga')->options(function ($id) {
                $administrators = Administrator::find($id);
                if ($administrators)
                    return [$administrators->id => $administrators->name];
            })->ajax('/admin/api/administrators');
            $form->datetime('processed_at', 'Kunci Diambil Pada')->format('YYYY-MM-DD HH:mm')->with(function ($value, Field $thisField) {
                $admin_approval_status = $this->admin_approval_status;
                if (
                    $admin_approval_status == null
                    || $admin_approval_status === ApprovalStatus::Pending
                    || $admin_approval_status === ApprovalStatus::Ditolak
                )
                    $thisField->attribute('readonly', 'readonly');
            });
            $form->datetime('returned_at', 'Diselesaikan Pada')->format('YYYY-MM-DD HH:mm')->with(function ($value, Field $thisField) {
                if ($this->processed_at == null)
                    $thisField->attribute('readonly', 'readonly');
            });
            $form->image('receipt', 'Bukti Pembayaran')->uniqueName()->removable();
            $form->currency('price', 'Jumlah Pembayaran')->symbol('Rp')->digits(0)->default(0);
            $form->datetime('payment_at', 'Tanggal Pembayaran')->format('YYYY-MM-DD HH:mm');
            $form->textarea('notes', 'Catatan');

            if ($form->isEditing()) {
                $form->display('created_at', trans('admin.created_at'));
                $form->display('updated_at', trans('admin.updated_at'));
            }
        }

        $form->saving(function (Form $form) {
            // if ($form->admin_id)
            $form->admin_id = \Admin::user()->id;
        });

        return $form;
    }

    public function approved(Content $content)
    {
        return $content
            ->header('<b>PENGAJUAN DISETUJUI</b>')
            ->description(trans('admin.list'))
            ->body($this->grid_approved());
    }

     /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid_approved()
    {
        $grid = new Grid(new BorrowRoom);

        $admin_user = \Admin::user();
        // Show query only related to roles
        if ($admin_user->isRole('peminjam'))
        $grid->model()->where('borrower_id', $admin_user->id);
        $grid->model()->where('admin_approval_status', 1);
        $grid->model()->whereNull('processed_at');
        $grid->model()->whereNull('returned_at');

        $grid->id('ID');
        $grid->column('full_name', 'Peminjam');
        $grid->column('borrower_status', 'Status Peminjam');
        $grid->column('email', 'Email');
        $grid->column('phone_number', 'Nomor Telepon');
        $grid->column('activity', 'Kegiatan');
        $grid->column('room.name', 'Ruangan');
        $grid->column('inventory_name', 'Inventory')->display(function () {
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

        // Role & Permission
        if (!\Admin::user()->can('create.borrow_rooms'))
            $grid->disableCreateButton();

        $grid->actions(function ($actions) {

            // The roles with this permission will not able to see the view button in actions column.
            if (!\Admin::user()->can('edit.borrow_rooms')) {
                $actions->disableEdit();
            }
            // The roles with this permission will not able to see the show button in actions column.
            if (!\Admin::user()->can('list.borrow_rooms')) {
                $actions->disableView();
            }
            // The roles with this permission will not able to see the delete button in actions column.
            if (!\Admin::user()->can('delete.borrow_rooms')) {
                $actions->disableDelete();
            }
        });

        return $grid;
    }

    public function denied(Content $content)
    {
        return $content
            ->header('<b>PENGAJUAN DITOLAK</b>')
            ->description(trans('admin.list'))
            ->body($this->grid_denied());
    }

     /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid_denied()
    {
        $grid = new Grid(new BorrowRoom);

        $admin_user = \Admin::user();
        // Show query only related to roles
        if ($admin_user->isRole('peminjam'))
        $grid->model()->where('borrower_id', $admin_user->id);
        $grid->model()->where('admin_approval_status', 2);

        $grid->id('ID');
        $grid->column('full_name', 'Peminjam');
        $grid->column('borrower_status', 'Status Peminjam');
        $grid->column('email', 'Email');
        $grid->column('phone_number', 'Nomor Telepon');
        $grid->column('activity', 'Kegiatan');
        $grid->column('room.name', 'Ruangan');
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

        // Role & Permission
        if (!\Admin::user()->can('create.borrow_rooms'))
            $grid->disableCreateButton();

        $grid->actions(function ($actions) {

            // The roles with this permission will not able to see the view button in actions column.
            if (!\Admin::user()->can('edit.borrow_rooms')) {
                $actions->disableEdit();
            }
            // The roles with this permission will not able to see the show button in actions column.
            if (!\Admin::user()->can('list.borrow_rooms')) {
                $actions->disableView();
            }
            // The roles with this permission will not able to see the delete button in actions column.
            if (!\Admin::user()->can('delete.borrow_rooms')) {
                $actions->disableDelete();
            }
        });

        return $grid;
    }

    public function ongoing(Content $content)
    {
        return $content
            ->header('<b>PEMINJAMAN BERJALAN</b>')
            ->description(trans('admin.list'))
            ->body($this->grid_ongoing());
    }

     /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid_ongoing()
    {
        $grid = new Grid(new BorrowRoom);

        $admin_user = \Admin::user();
        // Show query only related to roles
        if ($admin_user->isRole('peminjam'))
        $grid->model()->where('borrower_id', $admin_user->id);
        $grid->model()->whereNotNull('processed_at');
        $grid->model()->whereNull('returned_at');

        $grid->id('ID');
        $grid->column('full_name', 'Peminjam');
        $grid->column('borrower_status', 'Status Peminjam');
        $grid->column('email', 'Email');
        $grid->column('phone_number', 'Nomor Telepon');
        $grid->column('activity', 'Kegiatan');
        $grid->column('room.name', 'Ruangan');
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

        // Role & Permission
        if (!\Admin::user()->can('create.borrow_rooms'))
            $grid->disableCreateButton();

        $grid->actions(function ($actions) {

            // The roles with this permission will not able to see the view button in actions column.
            if (!\Admin::user()->can('edit.borrow_rooms')) {
                $actions->disableEdit();
            }
            // The roles with this permission will not able to see the show button in actions column.
            if (!\Admin::user()->can('list.borrow_rooms')) {
                $actions->disableView();
            }
            // The roles with this permission will not able to see the delete button in actions column.
            if (!\Admin::user()->can('delete.borrow_rooms')) {
                $actions->disableDelete();
            }
        });

        return $grid;
    }

    public function finished(Content $content)
    {
        return $content
            ->header('<b>PEMINJAMAN SELESAI</b>')
            ->description(trans('admin.list'))
            ->body($this->grid_finished());
    }

     /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid_finished()
    {
        $grid = new Grid(new BorrowRoom);

        $admin_user = \Admin::user();
        // Show query only related to roles
        if ($admin_user->isRole('peminjam'))
        $grid->model()->where('borrower_id', $admin_user->id);
        $grid->model()->whereNotNull('returned_at');

        $grid->id('ID');
        $grid->column('full_name', 'Peminjam');
        $grid->column('borrower_status', 'Status Peminjam');
        $grid->column('email', 'Email');
        $grid->column('phone_number', 'Nomor Telepon');
        $grid->column('activity', 'Kegiatan');
        $grid->column('deleted_at', 'Kegiatan');
        $grid->column('room.name', 'Ruangan');
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


        // Role & Permission
        if (!\Admin::user()->can('create.borrow_rooms'))
            $grid->disableCreateButton();

        $grid->actions(function ($actions) {

            // The roles with this permission will not able to see the view button in actions column.
            if (!\Admin::user()->can('edit.borrow_rooms')) {
                $actions->disableEdit();
            }
            // The roles with this permission will not able to see the show button in actions column.
            if (!\Admin::user()->can('list.borrow_rooms')) {
                $actions->disableView();
            }
            // The roles with this permission will not able to see the delete button in actions column.
            if (!\Admin::user()->can('delete.borrow_rooms')) {
                $actions->disableDelete();
            }
        });

        return $grid;
    }

    public function canceled(Content $content)
    {
        return $content
            ->header('<b>PEMINJAMAN BATAL</b>')
            ->description(trans('admin.list'))
            ->body($this->grid_canceled());
    }

     /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid_canceled()
    {
        $grid = new Grid(new BorrowRoom);

        $admin_user = \Admin::user();
        // Show query only related to roles
        if ($admin_user->isRole('peminjam'))
        $grid->model()->where('borrower_id', $admin_user->id);
        $grid->model()->withTrashed()->whereNotNull('deleted_at');

        $grid->id('ID');
        $grid->column('full_name', 'Peminjam');
        $grid->column('borrower_status', 'Status Peminjam');
        $grid->column('email', 'Email');
        $grid->column('phone_number', 'Nomor Telepon');
        $grid->column('activity', 'Kegiatan');
        $grid->column('room.name', 'Ruangan');
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
                    if ($this->deleted_at != null)
                        $val = ['danger', 'Dibatalkan'];


            return '<span class="label-' . $val[0] . '" style="width: 8px;height: 8px;padding: 0;border-radius: 50%;display: inline-block;"></span>&nbsp;&nbsp;'
                . $val[1];
        });

        // Role & Permission
        if (!\Admin::user()->can('create.borrow_rooms'))
            $grid->disableCreateButton();

        $grid->actions(function ($actions) {

            // The roles with this permission will not able to see the view button in actions column.
            if (!\Admin::user()->can('edit.borrow_rooms')) {
                $actions->disableEdit();
            }
            // The roles with this permission will not able to see the show button in actions column.
            if (!\Admin::user()->can('list.borrow_rooms')) {
                $actions->disableView();
            }
            // The roles with this permission will not able to see the delete button in actions column.
            if (!\Admin::user()->can('delete.borrow_rooms')) {
                $actions->disableDelete();
            }
        });

        return $grid;
    }
}
