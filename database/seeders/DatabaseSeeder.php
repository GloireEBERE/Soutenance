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
        // User::factory(10)->create();

        User::factory()->create([
            'nom' => 'Test',
            'prenom' => 'User',
            'email' => 'test@example.com',
            'contact' => '1234567890', // Ajoutez un contact fictif
            'role' => 'admin',         // Définissez un rôle (par exemple 'admin')
            'mot_de_passe' => bcrypt('password'), // Ajoutez un mot de passe sécurisé
        ]);
    }
}
