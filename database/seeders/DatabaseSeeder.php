<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // delete all data:
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // \App\Models\Product::truncate();
        // \App\Models\Category::truncate();
        // \App\Models\User::truncate();

        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        //create data:
         $this->call([
            'Database\Seeders\UserSeeder',
            'Database\Seeders\CategorySeeder',
            'Database\Seeders\ProductSeeder',
            'Database\Seeders\AddressSeeder',
            'Database\Seeders\AttributeSeeder',
            'Database\Seeders\CartSeeder',
            'Database\Seeders\ColorSeeder',
         ]);
        
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
