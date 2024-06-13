<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Read Only Administrator, šifra 12345',
            'email' => 'admin@example.com',
            'password' => Hash::make('12345'),
            'privilege_level'=>'administrator',
            'read_only' => true
        ]);
    }
}
