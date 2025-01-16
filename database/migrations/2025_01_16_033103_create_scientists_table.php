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
        Schema::create('scientists', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Name of the scientist
            $table->string('field'); // Field of expertise
            $table->string('specialization')->nullable(); // Specialization (nullable)
            $table->string('division')->nullable(); // Division (nullable)
            $table->year('year_awarded')->nullable(); // Year awarded (nullable)
            $table->timestamps(); // Created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scientists');
    }
};