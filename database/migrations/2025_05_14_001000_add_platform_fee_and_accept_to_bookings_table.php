<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->boolean('carebuddy_accepted')->default(false);
            $table->decimal('platform_fee', 8, 2)->nullable();
            $table->decimal('carebuddy_earnings', 8, 2)->nullable();
            $table->timestamp('accepted_at')->nullable();
        });
    }
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['carebuddy_accepted', 'platform_fee', 'carebuddy_earnings', 'accepted_at']);
        });
    }
};
