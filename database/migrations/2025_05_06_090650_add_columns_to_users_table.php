<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['parent', 'carebuddy', 'admin'])
                ->default('parent')
                ->after('email');

            $table->enum('verification_status', ['pending', 'approved', 'rejected'])
                ->default('pending')
                ->after('role');

            $table->boolean('registration_complete')->nullable()->after('verification_status')->default(false);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'verification_status', 'registration_complete']);
        });
    }
};
