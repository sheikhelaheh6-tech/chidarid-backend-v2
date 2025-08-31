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
        Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->enum('type', ['کافه', 'رستوران']); // نوع مجموعه
            $table->foreignId('province_id')->constrained('provinces')->cascadeOnDelete();
            $table->string('phone')->unique(); // شماره تماس
            $table->string('logo_path')->nullable(); // مسیر ذخیره لوگو
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provinces');
    }
};
