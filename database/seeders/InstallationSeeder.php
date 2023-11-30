<?php

namespace Database\Seeders;

use App\Models\Installation;
use Illuminate\Database\Seeder;

class InstallationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Installation::factory()
            ->count(5)
            ->create();
    }
}
