<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class userSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin',
            'password'=>Hash::make('admin'),
            'created_at'=>Carbon::now(),
            'phonenumber'=>'123456',
            'role'=>'admin'
        ]);
        DB::table('users')->insert([
            'name' => 'datle0310',
            'email' => 'datle0310@gmail.com',
            'password'=>Hash::make('datle0310'),
            'created_at'=>Carbon::now(),
            'phonenumber'=>'0346531944'

        ]);
        DB::table('users')->insert([
            'name' => 'queanh2004',
            'email' => 'queanh2004@gmail.com',
            'password'=>Hash::make('queanh2004'),
            'created_at'=>Carbon::now(),
            'phonenumber'=>'0346531944'

        ]);
        DB::table('users')->insert([
            'name' => 'belien1997',
            'email' => 'belien1997@gmail.com',
            'password'=>Hash::make('belien1997'),
            'created_at'=>Carbon::now(),
            'phonenumber'=>'0334582494'

        ]);
        DB::table('users')->insert([
            'name' => 'minhhien1995',
            'email' => 'minhhien1995@gmail.com',
            'password'=>Hash::make('minhhien1995'),
            'created_at'=>Carbon::now(),
            'phonenumber'=>'0334582494'

        ]);
    }
}
