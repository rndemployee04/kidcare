<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('parents', function (Blueprint $table) {
            $table->string('phone')->nullable()->change();
            $table->date('dob')->nullable()->change();
            $table->enum('gender', ['male', 'female', 'others'])->nullable()->change();
            $table->string('id_proof_path')->nullable()->change();
            $table->string('permanent_address')->nullable()->change();
            $table->string('current_address')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->string('state')->nullable()->change();
            $table->string('zip')->nullable()->change();
            $table->string('profession')->nullable()->change();
            $table->unsignedTinyInteger('number_of_children')->nullable()->change();
            $table->unsignedTinyInteger('number_needing_care')->nullable()->change();
            $table->enum('preferred_drop_off_time', ['morning', 'afternoon', 'evening', 'full_day'])->nullable()->change();
            $table->enum('preferred_type_of_caregiver', ['newlywed', 'professional', 'parent', 'senior', 'any'])->nullable()->change();
            $table->enum('preferred_radius', ['2-3', '3-4', '4-5'])->nullable()->change();
            $table->boolean('needs_special_needs_support')->nullable()->change();
            $table->string('emergency_contact_name')->nullable()->change();
            $table->string('emergency_contact_phone')->nullable()->change();
            $table->boolean('terms_accepted')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('parents', function (Blueprint $table) {
            $table->string('phone')->nullable(false)->change();
            $table->date('dob')->nullable(false)->change();
            $table->enum('gender', ['male', 'female', 'others'])->nullable(false)->change();
            $table->string('id_proof_path')->nullable(false)->change();
            $table->string('permanent_address')->nullable(false)->change();
            $table->string('current_address')->nullable(false)->change();
            $table->string('city')->nullable(false)->change();
            $table->string('state')->nullable(false)->change();
            $table->string('zip')->nullable(false)->change();
            $table->string('profession')->nullable(false)->change();
            $table->unsignedTinyInteger('number_of_children')->nullable(false)->change();
            $table->unsignedTinyInteger('number_needing_care')->nullable(false)->change();
            $table->enum('preferred_drop_off_time', ['morning', 'afternoon', 'evening', 'full_day'])->nullable(false)->change();
            $table->enum('preferred_type_of_caregiver', ['newlywed', 'professional', 'parent', 'senior', 'any'])->nullable(false)->change();
            $table->enum('preferred_radius', ['2-3', '3-4', '4-5'])->nullable(false)->change();
            $table->boolean('needs_special_needs_support')->nullable(false)->change();
            $table->string('emergency_contact_name')->nullable(false)->change();
            $table->string('emergency_contact_phone')->nullable(false)->change();
            $table->boolean('terms_accepted')->nullable(false)->change();
        });
    }
};
