<?php

namespace App\Models;

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventory extends Model
{
    use HasFactory, SoftDeletes;

    protected $tables = 'inventories';

    /**
     * Relationship
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function borrow_rooms()
    {
        return $this->hasMany(BorrowRoom::class);
    }
}