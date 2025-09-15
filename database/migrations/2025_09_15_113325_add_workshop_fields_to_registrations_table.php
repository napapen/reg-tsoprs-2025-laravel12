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
        Schema::table('registrations', function (Blueprint $table) {
            //
            $table->string('institution')->nullable()->after('cameratype');
            $table->string('camera_brand')->nullable()->after('institution');
            $table->enum('photography_experience', ['beginner','intermediate','advanced'])->nullable()->after('camera_brand');
            $table->string('workshop_topics')->nullable()->after('photography_experience'); // CSV
            $table->text('other_topics')->nullable()->after('workshop_topics');
            $table->text('equipment_questions')->nullable()->after('other_topics');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            //
            $table->dropColumn(['institution','camera_brand','photography_experience','workshop_topics','other_topics','equipment_questions']);

        });
    }
};
