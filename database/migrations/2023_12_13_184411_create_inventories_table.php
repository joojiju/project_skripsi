<?php

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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->integer('quantity');
            $table->tinyInteger('status')->default(0);
            $table->text('notes')->nullable();
            $table->foreignId('room_id')->constrained();
            $table->unsignedInteger('admin_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('inventories');
    }
};
