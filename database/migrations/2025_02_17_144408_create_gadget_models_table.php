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
        Schema::create('gadget_models', function (Blueprint $table) {
            $table->id();
            $table->string('type');  // Ex: Notebook, Desktop, Monitor
            $table->string('brand'); // Ex: Dell, HP, Lenovo
            $table->string('model'); // Ex: Latitude 5420, ProBook 440
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gadget_models');
    }
};
