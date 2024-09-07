<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(userSeed::class);
        $this->call(CategorySeed::class);
        $this->call(ProductSeed::class);
        $this->call(ProductDetailSeed::class);
        $this->call(ImagesSeed::class);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'admin',
        //     'email' => 'admin',
        //     'password'=>Hash::make('admin'),
        //     'created_at'=>Carbon::now(),
        // ]);
    }
}
