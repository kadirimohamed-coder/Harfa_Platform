<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── REVIEWS ───────────────────────────────────────
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->unique()->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('rating');      // 1-5
            $table->text('comment')->nullable();
            $table->timestamps();
        });

        // ── CHATS ─────────────────────────────────────────
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('receiver_id')->constrained('users')->cascadeOnDelete();
            $table->text('message');
            $table->timestamps();

            $table->index(['sender_id', 'receiver_id']);
        });

        // ── GIGS ──────────────────────────────────────────
        Schema::create('gigs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();          // client
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('title', 150);
            $table->text('description');
            $table->string('city', 80);
            $table->date('deadline')->nullable();
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->timestamps();
        });

        // ── GIG APPLICATIONS ──────────────────────────────
        Schema::create('gig_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gig_id')->constrained()->cascadeOnDelete();
            $table->foreignId('craftsman_id')->constrained()->cascadeOnDelete();
            $table->text('message')->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamps();

            $table->unique(['gig_id', 'craftsman_id']);
        });

        // ── POINT TRANSACTIONS ────────────────────────────
        Schema::create('point_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('amount');                  // can be negative (spend)
            $table->string('type', 20);                 // purchase | spend | bonus
            $table->string('description');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('point_transactions');
        Schema::dropIfExists('gig_applications');
        Schema::dropIfExists('gigs');
        Schema::dropIfExists('chats');
        Schema::dropIfExists('reviews');
    }
};
