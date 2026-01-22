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
        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requester_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('game_owner_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('requested_game_id')->constrained('games')->onDelete('cascade');
            $table->foreignId('offered_game_id')->nullable()->constrained('games')->onDelete('set null');
            $table->enum('status', ['pending', 'accepted', 'declined', 'completed'])->default('pending');
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trades');
    }
};
