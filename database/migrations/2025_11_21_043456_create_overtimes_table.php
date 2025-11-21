<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('overtimes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('staff_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->foreignId('leader_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->foreignId('approved_by')
                  ->nullable()
                  ->constrained('users');

            $table->date('tanggal');
            $table->time('mulai_jam');
            $table->time('selesai_jam');
            $table->integer('total_jam');
            $table->string('alasan');
            $table->enum('status', ['pending', 'approved', 'rejected'])
                  ->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('overtimes');
    }
};

