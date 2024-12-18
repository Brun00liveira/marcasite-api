<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserWithRolesAndPermissionsSeeder::class);
        $this->call(CategoryAndCourseSeeder::class);
        $this->call(PlanSeeder::class);
    }
}
