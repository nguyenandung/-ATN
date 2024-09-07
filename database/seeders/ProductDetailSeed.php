<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class ProductDetailSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_detail')->insert([
            'product_id' => '1',
            'color' => 'Đỏ',
            'size'=>'M',
            'quantity'=>'10',
            'created_at'=>Carbon::now(),
        ]);
        DB::table('product_detail')->insert([
            'product_id' => '1',
            'color' => 'Đỏ',
            'size'=>'L',
            'quantity'=>'10',
            'created_at'=>Carbon::now(),
        ]);
        DB::table('product_detail')->insert([
            'product_id' => '1',
            'color' => 'Đỏ',
            'size'=>'XL',
            'quantity'=>'10',
            'created_at'=>Carbon::now(),
        ]);
        DB::table('product_detail')->insert([
            'product_id' => '1',
            'color' => 'Đen',
            'size'=>'XL',
            'quantity'=>'10',
            'created_at'=>Carbon::now(),
        ]);
        DB::table('product_detail')->insert([
            'product_id' => '1',
            'color' => 'Đen',
            'size'=>'L',
            'quantity'=>'10',
            'created_at'=>Carbon::now(),
        ]);
        DB::table('product_detail')->insert([
            'product_id' => '1',
            'color' => 'Đen',
            'size'=>'M',
            'quantity'=>'10',
            'created_at'=>Carbon::now(),
        ]);
        DB::table('product_detail')->insert([
            'product_id' => '1',
            'color' => 'Trắng',
            'size'=>'XL',
            'quantity'=>'10',
            'created_at'=>Carbon::now(),
        ]);
        DB::table('product_detail')->insert([
            'product_id' => '1',
            'color' => 'Trắng',
            'size'=>'L',
            'quantity'=>'10',
            'created_at'=>Carbon::now(),
        ]);
        DB::table('product_detail')->insert([
            'product_id' => '1',
            'color' => 'Trắng',
            'size'=>'M',
            'quantity'=>'20',
            'created_at'=>Carbon::now(),
        ]);

        DB::table('product_detail')->insert([
            'product_id' => '1',
            'color' => 'Trắng',
            'size'=>'M',
            'quantity'=>'20',
            'created_at'=>Carbon::now(),
        ]);

        DB::table('product_detail')->insert([
            'product_id' => '2',
            'color' => 'Be nhung tăm',
            'size'=>'M',
            'quantity'=>'10',
            'created_at'=>Carbon::now(),
        ]);
        DB::table('product_detail')->insert([
            'product_id' => '2',
            'color' => 'Be nhung tăm',
            'size'=>'L',
            'quantity'=>'10',
            'created_at'=>Carbon::now(),
        ]);
        DB::table('product_detail')->insert([
            'product_id' => '2',
            'color' => 'Be nhung tăm',
            'size'=>'XL',
            'quantity'=>'10',
            'created_at'=>Carbon::now(),
        ]);
        DB::table('product_detail')->insert([
            'product_id' => '2',
            'color' => 'Nâu nhung tăm',
            'size'=>'M',
            'quantity'=>'10',
            'created_at'=>Carbon::now(),
        ]);
        DB::table('product_detail')->insert([
            'product_id' => '2',
            'color' => 'Nâu nhung tăm',
            'size'=>'L',
            'quantity'=>'10',
            'created_at'=>Carbon::now(),
        ]);
        DB::table('product_detail')->insert([
            'product_id' => '2',
            'color' => 'Nâu nhung tăm',
            'size'=>'XL',
            'quantity'=>'10',
            'created_at'=>Carbon::now(),
        ]);
        DB::table('product_detail')->insert([
            'product_id' => '2',
            'color' => 'Đen nhung tăm',
            'size'=>'XL',
            'quantity'=>'10',
            'created_at'=>Carbon::now(),
        ]);
        DB::table('product_detail')->insert([
            'product_id' => '2',
            'color' => 'Đen nhung tăm',
            'size'=>'L',
            'quantity'=>'10',
            'created_at'=>Carbon::now(),
        ]);
        DB::table('product_detail')->insert([
            'product_id' => '2',
            'color' => 'Đen nhung tăm',
            'size'=>'M',
            'quantity'=>'20',
            'created_at'=>Carbon::now(),
        ]);

        DB::table('product_detail')->insert([
            'product_id' => '3',
            'color' => 'Xanh',
            'size'=>'M',
            'quantity'=>'10',
            'created_at'=>Carbon::now(),
        ]);
        DB::table('product_detail')->insert([
            'product_id' => '3',
            'color' => 'Xanh',
            'size'=>'L',
            'quantity'=>'10',
            'created_at'=>Carbon::now(),
        ]);
        DB::table('product_detail')->insert([
            'product_id' => '3',
            'color' => 'Xanh',
            'size'=>'XL',
            'quantity'=>'10',
            'created_at'=>Carbon::now(),
        ]);

        DB::table('product_detail')->insert([
            'product_id' => '3',
            'color' => 'Nâu',
            'size'=>'XL',
            'quantity'=>'10',
            'created_at'=>Carbon::now(),
        ]);DB::table('product_detail')->insert([
            'product_id' => '3',
            'color' => 'Nâu',
            'size'=>'L',
            'quantity'=>'10',
            'created_at'=>Carbon::now(),
        ]);DB::table('product_detail')->insert([
            'product_id' => '3',
            'color' => 'Nâu',
            'size'=>'M',
            'quantity'=>'10',
            'created_at'=>Carbon::now(),
        ]);
        
        DB::table('product_detail')->insert([
            'product_id' => '3',
            'color' => 'Đen',
            'size'=>'XL',
            'quantity'=>'10',
            'created_at'=>Carbon::now(),
        ]);DB::table('product_detail')->insert([
            'product_id' => '3',
            'color' => 'Đen',
            'size'=>'L',
            'quantity'=>'10',
            'created_at'=>Carbon::now(),
        ]);DB::table('product_detail')->insert([
            'product_id' => '3',
            'color' => 'Đen',
            'size'=>'M',
            'quantity'=>'20',
            'created_at'=>Carbon::now(),
        ]);

        DB::table('product_detail')->insert([
            'product_id' => '4',
            'color' => 'Đen',
            'size'=>'M',
            'quantity'=>'10',
            'created_at'=>Carbon::now(),
        ]);
        DB::table('product_detail')->insert([
            'product_id' => '4',
            'color' => 'Đen',
            'size'=>'L',
            'quantity'=>'10',
            'created_at'=>Carbon::now(),
        ]);
        DB::table('product_detail')->insert([
            'product_id' => '4',
            'color' => 'Đen',
            'size'=>'XL',
            'quantity'=>'10',
            'created_at'=>Carbon::now(),
        ]);

        DB::table('product_detail')->insert([
            'product_id' => '4',
            'color' => 'Nâu',
            'size'=>'XL',
            'quantity'=>'10',
            'created_at'=>Carbon::now(),
        ]);DB::table('product_detail')->insert([
            'product_id' => '4',
            'color' => 'Nâu',
            'size'=>'L',
            'quantity'=>'10',
            'created_at'=>Carbon::now(),
        ]);DB::table('product_detail')->insert([
            'product_id' => '4',
            'color' => 'Nâu',
            'size'=>'M',
            'quantity'=>'10',
            'created_at'=>Carbon::now(),
        ]);
        
        DB::table('product_detail')->insert([
            'product_id' => '4',
            'color' => 'Hồng',
            'size'=>'XL',
            'quantity'=>'10',
            'created_at'=>Carbon::now(),
        ]);DB::table('product_detail')->insert([
            'product_id' => '4',
            'color' => 'Hồng',
            'size'=>'L',
            'quantity'=>'10',
            'created_at'=>Carbon::now(),
        ]);DB::table('product_detail')->insert([
            'product_id' => '4',
            'color' => 'Hồng',
            'size'=>'M',
            'quantity'=>'20',
            'created_at'=>Carbon::now(),
        ]);

        // DB::table('product_detail')->insert([
        //     'product_id' => '5',
        //     'color' => 'Đen',
        //     'size'=>'M',
        //     'quantity'=>'10',
        //     'created_at'=>Carbon::now(),
        // ]);
        // DB::table('product_detail')->insert([
        //     'product_id' => '5',
        //     'color' => 'Đen',
        //     'size'=>'L',
        //     'quantity'=>'10',
        //     'created_at'=>Carbon::now(),
        // ]);
        // DB::table('product_detail')->insert([
        //     'product_id' => '5',
        //     'color' => 'Đen',
        //     'size'=>'XL',
        //     'quantity'=>'10',
        //     'created_at'=>Carbon::now(),
        // ]);

        // DB::table('product_detail')->insert([
        //     'product_id' => '5',
        //     'color' => 'Xanh than',
        //     'size'=>'XL',
        //     'quantity'=>'10',
        //     'created_at'=>Carbon::now(),
        // ]);DB::table('product_detail')->insert([
        //     'product_id' => '5',
        //     'color' => 'Xanh than',
        //     'size'=>'XL',
        //     'quantity'=>'10',
        //     'created_at'=>Carbon::now(),
        // ]);DB::table('product_detail')->insert([
        //     'product_id' => '5',
        //     'color' => 'Xanh than',
        //     'size'=>'XL',
        //     'quantity'=>'10',
        //     'created_at'=>Carbon::now(),
        // ]);
        
        // DB::table('product_detail')->insert([
        //     'product_id' => '5',
        //     'color' => 'Cà phê',
        //     'size'=>'XL',
        //     'quantity'=>'10',
        //     'created_at'=>Carbon::now(),
        // ]);DB::table('product_detail')->insert([
        //     'product_id' => '5',
        //     'color' => 'Cà phê',
        //     'size'=>'XL',
        //     'quantity'=>'10',
        //     'created_at'=>Carbon::now(),
        // ]);DB::table('product_detail')->insert([
        //     'product_id' => '5',
        //     'color' => 'Cà phê',
        //     'size'=>'XL',
        //     'quantity'=>'20',
        //     'created_at'=>Carbon::now(),
        // ]);
    }
}
