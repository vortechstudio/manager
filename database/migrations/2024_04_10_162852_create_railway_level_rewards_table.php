<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('railway_level_rewards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('action')->nullable();
            $table->integer('action_count');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('railway_level_rewards');
    }
};
