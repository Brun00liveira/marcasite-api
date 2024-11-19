<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    public function run()
    {
        $plans = [
            [
                'name' => 'Plano Basic',
                'description' => 'Plano com recursos básicos',
                'price' => 99.99,
                'created_at' => '2024-11-19 05:17:45',
                'updated_at' => '2024-11-19 05:17:45',
            ],
            [
                'name' => 'Plano Premium',
                'description' => 'Plano com recursos avançados',
                'price' => 159.99,
                'created_at' => '2024-11-19 05:20:37',
                'updated_at' => '2024-11-19 05:20:37',
            ],
            [
                'name' => 'Plano Business',
                'description' => 'Plano com recursos ilimitados e aulas particulares com o professor do curso',
                'price' => 259.99,
                'created_at' => '2024-11-19 05:21:09',
                'updated_at' => '2024-11-19 05:21:09',
            ],
        ];

        foreach ($plans as $planData) {
            Plan::firstOrCreate(
                ['name' => $planData['name']],
                $planData
            );
        }
    }
}
