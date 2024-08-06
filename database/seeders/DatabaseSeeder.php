<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(100)->create();

         /*\App\Models\User::factory()->create([
             'name' => 'Antoine Andre',
             'email' => 'antoine@gmail.com',
             'username' => 'ayolos',
             'password' => bcrypt('Tokyo2001.')
        ]);*/
    }
}
