<?php

namespace App\Models;

use App\Enums\ApprovalStatus;
use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BorrowRoom extends Model
{
    use SoftDeletes;

    protected $table = 'borrow_rooms';
    protected $casts = [
        'inventory_id' => 'json',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'borrower_id',
        'email',
        'full_name',
        'phone_number',
        'status_peminjam',
        'activity',
        'room_id',
        'inventory_id',
        'borrow_at',
        'until_at',
        'admin_id',
        'admin_approval_status',
        'processed_at',
        'returned_at',
        'notes',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    // protected $casts = [];

    /**
     * Relationship
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function inventory()
    {
        return $this->hasMany(Inventory::class, 'id', 'inventory_id');
    }

    public function borrower()
    {
        return $this->belongsTo(Administrator::class);
    }

    public function admin()
    {
        return $this->belongsTo(Administrator::class);
    }

    /**
     * Scope
     *
     */
    public function scopeIsNotFinished($query)
    {
        return $query->where('admin_approval_status', '!=', 2)->where('returned_at', '=', null);
    }

    public function scopeIsAdminApproved($query)
    {
        return $query->where('Admin_approval_status', '=', ApprovalStatus::Disetujui());
    }

    /**
     * Accessor
     */


    /**
     * Mutators
     */

     public function scopeTrashed($query)
    {
        return $query->onlyTrashed();
    }
}
