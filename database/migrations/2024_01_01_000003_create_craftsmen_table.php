<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('craftsmen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('experience_years')->default(0);
            $table->decimal('price', 10, 2)->nullable();
            $table->string('certification')->nullable();
            $table->boolean('availability_status')->default(true);
            $table->timestamps();
        });

        // Pivot: craftsman <-> category ndiroha f migration bo7dha
        
    }

    public function down(): void
    {
        Schema::dropIfExists('craftsmen');
    }
};
