<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credits', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('amount', 10, 2);
            $table->decimal('rate', 5, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->string('client_pin');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credits');
    }
};
