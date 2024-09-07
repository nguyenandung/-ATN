<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;



class ProductSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // anh: vn-11134207-7r98o-ltg8aw6z7xmyfa.jpg,vn-11134207-7r98o-ltg8aw6zdjwq49.jpg,vn-11134207-7r98o-ltg8aw6z9c7e3a.jpg
        DB::table('products')->insert([
            'category_id' => '1',
            'name' => 'Áo Thun Soccer Phối Local Brand By UniSpace Our Ground Áo Phông Unisex Pao_STORE',
            'description'=>'Không còn là những chiếc áo đơn điệu, áo thun đã được nghiên cứu, phát triển và kết hợp với nhiều chất liệu, chủ để khác nhau để cho ra ',
            'price'=>'69000',
            
            'status'=>'1',
            'slug'=>Str::slug('Áo Thun Soccer Phối Local Brand By UniSpace Our Ground Áo Phông Unisex Pao_STORE'),
            'stock'=>'100',
            'create_at'=>Carbon::now(),
            'create_by'=>'admin'
        ]);

        //vn-50009109-7b57c0c47015ece51b7b79f3cdfc388e.png,vn-11134207-7qukw-lk0onee5bmb8cc.jpg,vn-11134207-7qukw-lk0onedvetxe4e.jpg
        DB::table('products')->insert([
            'category_id' => '1',
            'name' => 'Áo sơ mi nam nữ tay ngắn chất nhung tăm cao cấp kiểu dáng form rộng, unisex, basic mặc cực đẹp',
            'description'=>'⭐ Tên sản phẩm : Áo sơ mi nhung tăm tay lỡ nam nữ unisex basic cao cấp
                            ⭐ Chất Liệu: nhung tăm cao cấp ',
            'price'=>'76000',
            'status'=>'1',
            'slug'=>Str::slug('Áo sơ mi nam nữ tay ngắn chất nhung tăm cao cấp kiểu dáng form rộng, unisex, basic mặc cực đẹp'),
            'stock'=>'100',
            'create_at'=>Carbon::now(),
            'create_by'=>'admin'
        ]);

        //vn-50009109-7b57c0c47015ece51b7b79f3cdfc388e (1).png,vn-11134207-7r98o-lpj8po1wn60lae.jpg,vn-11134207-7qukw-lh39bhv08w6r99.jpg
        DB::table('products')->insert([
            'category_id' => '2',
            'name' => 'Quần jeans nữ ống loe co giãn, quần bò jean nữ ống đứng rộng suông CẠP CAO cao cấp Hottrend 2023 LUNA T023',
            'description'=>'Quần jeans nữ ống loe co giãn, quần bò jean nữ ống đứng rộng suông CẠP CAO cao cấp Hottrend 2023 LUNA T023',
            'price'=>'89000',
            'status'=>'1',
            'slug'=>Str::slug('Quần jeans nữ ống loe co giãn, quần bò jean nữ ống đứng rộng suông CẠP CAO cao cấp Hottrend 2023 LUNA T023'),
            'stock'=>'100',
            'create_at'=>Carbon::now(),
            'create_by'=>'admin'
        ]);
        //vn-50009109-af49a7e1cedb5dc564b6d5fcffe97a12.png,vn-11134207-7r98o-lrd3820aga10d5.jpg,vn-11134207-7r98o-lrd3820akhqc82.jpg
        DB::table('products')->insert([
            'category_id' => '2',
            'name' => 'Áo Thun AM Nam Nữ Tay Lỡ Form Rộng ALTHOUGH Ullzang',
            'description'=>'Chất liệu: thun cotton su 35/65
                            Áo Size M < 45 kg, dài 63 ngang 47
                            Áo Size L < 65kg, dài 70 ngang 55',
            'price'=>'35000',
            'status'=>'1',
            'slug'=>Str::slug('Áo Thun AM Nam Nữ Tay Lỡ Form Rộng ALTHOUGH Ullzang'),
            'stock'=>'100',
            'create_at'=>Carbon::now(),
            'create_by'=>'admin'
        ]);

        // DB::table('products')->insert([
        //     'category_id' => '3',
        //     'name' => 'PAULWEEKEND Áo Khoác Hoodie Lót Nhung Dáng Rộng Thời Trang Xuân Thu Cho Nam',
        //     'description'=>'Chiều dài tay áo: tay áo dài
        //                     Kiểu cổ áo: Có mũ trùm đầu',
        //     'price'=>'177000',
        //     'status'=>'1',
        //     'slug'=>Str::slug('PAULWEEKEND Áo Khoác Hoodie Lót Nhung Dáng Rộng Thời Trang Xuân Thu Cho Nam'),
        //     'stock'=>'100',
        //     'create_at'=>Carbon::now(),
        //     'create_by'=>'admin'
        // ]);
    }
}
