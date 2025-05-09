<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('children', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('parent_id')->index();
            $table->foreign('parent_id', 'children_parent_id_foreign')
                ->references('id')
                ->on('parents')
                ->onDelete('cascade');

            // Basic Info
            $table->string('full_name');
            $table->date('dob');
            $table->enum('gender', ['male', 'female', 'others']);
            $table->string('photo')->nullable();

            // Verification Documents
            $table->string('birth_certificate_path');
            $table->string('id_proof_path')->nullable();

            // Health & Safety
            $table->boolean('has_insurance')->default(false);
            $table->string('insurance_company')->nullable();
            $table->text('insurance_terms')->nullable();

            $table->json('diseases')->nullable(); // e.g., ["Asthma", "Other:Thalassemia"]
            $table->json('disabilities')->nullable(); // e.g., ["Mobility", "Other:Speech delay"]
            $table->json('allergies')->nullable(); // e.g., ["Peanuts", "Other:Strawberries"]

            // Preferences
            $table->text('hobbies')->nullable(); // e.g., "Loves drawing, playing with blocks"

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('children');
    }
};
