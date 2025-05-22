<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Parents;

class ParentSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('role', 'parent')->first();
        if ($user && !Parents::where('user_id', $user->id)->exists()) {
            Parents::factory()->create(['user_id' => $user->id]);
        }
    }
}
