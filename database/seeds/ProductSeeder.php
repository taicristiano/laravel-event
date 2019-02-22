<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'name' => 'MacBook Pro (15 inch)',
                'description' => 'This laptop has a super crisp Retina display. Yes, we know that it\'s overpriced...',
                'price' => 2999,
                'inStock' => 50,
                'image' => 'https://macone.vn/wp-content/uploads/2018/06/15inch_2018_gray.jpg',
                'uuid' => (string) Str::uuid(),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Samsung Galaxy Note 7',
                'description' => 'Unlike the overpriced MacBook Pro, we\'re selling this one a bit cheap...',
                'price' => 299,
                'inStock' => 755,
                'image' => 'https://cdn.fptshop.com.vn/Uploads/Originals/2016/8/5/636060120230577954_s7-silver-1.jpg',
                'uuid' => (string) Str::uuid(),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'HP Officejet 5740 printer',
                'description' => 'This one might not last for so long, but hey, printers never work anyways, right?',
                'price' => 149,
                'inStock' => 5,
                'image' => 'https://ssl-product-images.www8-hp.com/digmedialib/prodimg/lowres/c04339763.png',
                'uuid' => (string) Str::uuid(),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'iPhone 7 cover',
                'description' => 'Having problems keeping a hold of that phone, huh? Ever considered not dropping ...',
                'price' => 49,
                'inStock' => 42,
                'image' => 'http://trianium.com/wp-content/uploads/2016/10/00120.jpg',
                'uuid' => (string) Str::uuid(),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'iPad Pro (9.7 inch)',
                'description' => 'We heard it\'s supposed to be pretty good. At least that\'s what people say.',
                'price' => 599,
                'inStock' => 0,
                'image' => 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/image/AppleInc/aos/published/images/r/fb/rfb/97/rfb-97-ipad-pro-silver-wifi-2015?wid=572&hei=572&fmt=jpeg&qlt=95&op_usm=0.5,0.5&.v=1542160026733',
                'uuid' => (string) Str::uuid(),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'OnePlus 3 cover',
                'description' => 'Does your phone spend most of its time on the ground? This cheap piece of plastic ...',
                'price' => 19,
                'inStock' => 81,
                'image' => 'https://ae01.alicdn.com/kf/HTB1KgiDKVXXXXclXVXXq6xXFXXXp/Oneplus-3-tr-ng-h-p-B-Thu-S-n-ban-u-c-ng-M-Y.jpg',
                'uuid' => (string) Str::uuid(),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        DB::table('products')->insert($products);
    }
}
