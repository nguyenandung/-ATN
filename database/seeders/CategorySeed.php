<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class CategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            'name' => 'Quần áo nam',
            'description' => 'Quần áo nam đẹp',
            'status'=>'1',
            'created_at'=>Carbon::now(),
        ]);
         DB::table('categories')->insert([
            'name' => 'Quần áo nữ',
            'description' => 'Quần áo nữ đẹp',
            'status'=>'1',
            'created_at'=>Carbon::now(),
        ]);
         DB::table('categories')->insert([
            'name' => 'Áo khoác',
            'description' => 'Áo khoác đẹp',
            'status'=>'1',
            'created_at'=>Carbon::now(),
        ]);
         DB::table('categories')->insert([
            'name' => 'Phụ kiện',
            'description' => 'Phụ kiện',
            'status'=>'1',
            'created_at'=>Carbon::now(),
        ]);
        DB::table('categories')->insert([
            'name' => 'Giày dép',
            'description' => 'Giày dép',
            'status'=>'1',
            'created_at'=>Carbon::now(),
        ]);
    }
}
