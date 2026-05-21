<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            roles::class,               
            // TipoDependenciaSeeder::class,
        ]);

        $this->call([
            dependencias::class,      
        ]);

        $this->call([
            users::class,        
        ]);
    }
}