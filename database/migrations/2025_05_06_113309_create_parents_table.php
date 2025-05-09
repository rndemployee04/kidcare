<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id', 'parents_user_id_foreign')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            // Personal Info
            $table->string('phone');
            $table->date('dob');
            $table->enum('gender', ['male', 'female', 'others']);
            $table->string('profile_photo')->nullable();

            // ID Proof
            $table->string('id_proof_path');

            // Address Info
            $table->string('permanent_address');
            $table->string('current_address');
            $table->string('city')->index();
            $table->string('state');
            $table->string('zip');

            // Professional Info
            $table->string('profession');
            $table->string('spouse_name')->nullable();
            $table->string('spouse_email')->nullable();
            $table->string('spouse_phone')->nullable();
            $table->string('spouse_profession')->nullable();
            $table->enum('monthly_income', ['<50K', '50–100K', '100–200K', '200K+'])->nullable();

            // Preferences
            $table->unsignedTinyInteger('number_of_children')->default(1);
            $table->unsignedTinyInteger('number_needing_care')->default(1);
            $table->enum('preferred_drop_off_time', ['morning', 'afternoon', 'evening', 'full_day'])->default('full_day');
            $table->enum('preferred_type_of_caregiver', ['newlywed', 'professional', 'parent', 'senior', 'any'])->default('any');
            $table->enum('preferred_radius', ['2-3', '3-4', '4-5']);

            $table->boolean('needs_special_needs_support')->default(false);
            $table->text('reason_for_service')->nullable();

            $table->string('emergency_contact_name');
            $table->string('emergency_contact_phone');
            $table->boolean('terms_accepted')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parents');
    }
};
