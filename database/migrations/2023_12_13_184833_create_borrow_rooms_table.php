<?php

use App\Enums\ApprovalStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('borrow_rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('borrower_id');
            $table->string('email');
            $table->string('full_name');
            $table->integer('phone_number');
            $table->string('status_peminjam');
            $table->string('activity');
            $table->foreignId('room_id')->constrained();
            $table->foreignId('inventory_id')->constrained();
            $table->dateTime('borrow_at');
            $table->dateTime('until_at');
            $table->unsignedInteger('admin_id')->nullable();
            $table->tinyInteger('admin_approval_status')->nullable();
            $table->dateTime('processed_at')->nullable();
            $table->dateTime('returned_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('borrower_id')
                ->references('id')->on('admin_users')
                ->onUpdate('CASCADE')
                ->onDelete('RESTRICT');
            $table->foreign('admin_id')
                ->references('id')->on('admin_users')
                ->onUpdate('CASCADE')
                ->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrow_rooms');
    }
};
