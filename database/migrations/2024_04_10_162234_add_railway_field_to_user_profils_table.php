<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_profils', function (Blueprint $table) {
            $table->integer('railway_level')->default(0);
            $table->bigInteger('railway_xp')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('user_profils', function (Blueprint $table) {
            $table->dropColumn(['railway_level', 'railway_xp']);
        });
    }
};
