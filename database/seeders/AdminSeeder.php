<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin account
        User::updateOrCreate(
            ['email' => 'admin@olufunkefa.com'],
            [
                'name'     => 'OFA Admin',
                'email'    => 'admin@olufunkefa.com',
                'password' => Hash::make('OFA@admin2025'),
                'role'     => 'admin',
                'status'   => 'approved',
            ]
        );

        // Create a demo approved player
        User::updateOrCreate(
            ['email' => 'player@olufunkefa.com'],
            [
                'name'        => 'Demo Player',
                'email'       => 'player@olufunkefa.com',
                'password'    => Hash::make('Player@2025'),
                'role'        => 'player',
                'status'      => 'approved',
                'phone'       => '09079917993',
                'position'    => 'Midfielder',
                'age'         => 17,
                'nationality' => 'Nigerian',
                'age_group'   => 'U17',
            ]
        );

        // Create a demo approved Guardian
        User::updateOrCreate(
            ['email' => 'guardian@olufunkefa.com'],
            [
                'name'        => 'Demo Guardian',
                'email'       => 'guardian@olufunkefa.com',
                'password'    => Hash::make('Guardian@2025'),
                'role'        => 'guardian',
                'status'      => 'approved',
                'phone'       => '09079917993',
                'position'    => 'Parent/Guardian',
                'age'         => 0,
                'nationality' => 'Nigerian',
                'age_group'   => 'N/A',
            ]
        );
    }
}
