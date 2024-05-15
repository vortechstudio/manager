<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_railway_mouvements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->decimal('amount');
            $table->string('type_amount');
            $table->string('type_mvm');
            $table->foreignId('user_railway_company_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_railway_mouvements');
    }
};
