<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ManagedUser;

class ManagedUserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Xyra Feche',
                'email' => 'xf@gmail.com',
                'role' => 'Water Seeker',
                'status' => 'Active',
            ],
            [
                'name' => 'Ramil Alcontin',
                'email' => 'ramil.alcontin@gmail.com',
                'role' => 'Water Seeker',
                'status' => 'Active',
            ],
            [
                'name' => 'Maricar Dizon',
                'email' => 'maricar.dizon@yahoo.com',
                'role' => 'Water Seeker',
                'status' => 'Active',
            ],
            [
                'name' => 'Engr. Junrel Plaza',
                'email' => 'junrel.plaza@waterseeker.gov',
                'role' => 'Admin',
                'status' => 'Active',
            ],
            [
                'name' => 'Analyn Tiongson',
                'email' => 'analyn.tiongson@gmail.com',
                'role' => 'Water Seeker',
                'status' => 'Inactive',
            ],
        ];

        foreach ($users as $user) {
            ManagedUser::create($user);
        }
    }
}