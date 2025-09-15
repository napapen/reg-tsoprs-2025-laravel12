<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transid_sequences', function (Blueprint $table) {
            $table->id();
            $table->string('date', 8); // YYYYMMDD
            $table->unsignedInteger('last_no')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transid_sequences');
    }
};
