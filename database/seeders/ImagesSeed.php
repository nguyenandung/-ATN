<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class ImagesSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('images')->insert([
            'product_id' => '1',
            'url' => 'vn-11134207-7r98o-ltg8aw6z7xmyfa.jpg',
            'created_at'=>Carbon::now(),
        ]);
        DB::table('images')->insert([
            'product_id' => '1',
            'url' => 'vn-11134207-7r98o-ltg8aw6zdjwq49.jpg',
            'created_at'=>Carbon::now(),
        ]);
        DB::table('images')->insert([
            'product_id' => '1',
            'url' => 'vn-11134207-7r98o-ltg8aw6z9c7e3a.jpg',
            'created_at'=>Carbon::now(),
        ]);

        DB::table('images')->insert([
            'product_id' => '2',
            'url' => 'vn-11134207-7qukw-lk0onee5bmb8cc.jpg',
            'created_at'=>Carbon::now(),
        ]);
        DB::table('images')->insert([
            'product_id' => '2',
            'url' => 'vn-11134207-7qukw-lk0onedvetxe4e.jpg',
            'created_at'=>Carbon::now(),
        ]);


        DB::table('images')->insert([
            'product_id' => '3',
            'url' => 'vn-11134207-7r98o-lpj8po1wn60lae.jpg',
            'created_at'=>Carbon::now(),
        ]);
        DB::table('images')->insert([
            'product_id' => '3',
            'url' => 'vn-11134207-7qukw-lh39bhv08w6r99.jpg',
            'created_at'=>Carbon::now(),
        ]);

        DB::table('images')->insert([
            'product_id' => '4',
            'url' => 'vn-11134207-7r98o-lrd3820aga10d5.jpg',
            'created_at'=>Carbon::now(),
        ]);
        DB::table('images')->insert([
            'product_id' => '4',
            'url' => 'vn-11134207-7r98o-lrd3820akhqc82.jpg',
            'created_at'=>Carbon::now(),
        ]);


        // DB::table('images')->insert([
        //     'product_id' => '5',
        //     'url' => 'vn-11134207-7r98o-lrd3820aga10d5.jpg',
        //     'created_at'=>Carbon::now(),
        // ]);
        // DB::table('images')->insert([
        //     'product_id' => '5',
        //     'url' => 'vn-11134207-7r98o-lrd3820akhqc82.jpg',
        //     'created_at'=>Carbon::now(),
        // ]);
    }
}
