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
        Schema::table('games', function (Blueprint $table) {
            $table->string('genre')->nullable()->after('platform');
            $table->string('condition')->nullable()->after('genre');
            $table->integer('release_year')->nullable()->after('condition');
            $table->boolean('is_for_trade')->default(true)->after('release_year');
            $table->boolean('is_blocked')->default(false)->after('is_for_trade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn(['genre', 'condition', 'release_year', 'is_for_trade', 'is_blocked']);
        });
    }
};
