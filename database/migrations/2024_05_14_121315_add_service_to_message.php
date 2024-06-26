<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mysql')->table('messages', function (Blueprint $table) {
            $table->foreignId('service_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::connection('mysql')->table('messages', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
        });
    }
};
