<?php

namespace Database\Seeders;

use App\Models\UserMeta;
use Illuminate\Database\Seeder;

class UserMetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserMeta::factory()
            ->count(5)
            ->create();
    }
}
