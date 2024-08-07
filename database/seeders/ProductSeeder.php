<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Config;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker= Faker::create();

        foreach(range(1,100) as $value){
            Product::create([
                'pr_name'=>$faker->randomElement(Brand::pluck('name')).'Watch',
                'brand_id'=>$faker->randomElement(Brand::pluck('id')),
                'pr_sale_price'=>$faker->numberBetween($int1=500,$int2=2990),
                'pr_price'=>$faker->numberBetween($int1=3000,$int2=50000),
                'pr_color'=>$faker->randomElement(['Gold','Rose Gold','Silver','Black','Beige','Blue','Green']),
                'pr_code'=>$faker->numerify('LV-#####'),
                'pr_gender'=>$faker->randomElement(['male','female','children','unisex']),
                'pr_function'=>$faker->randomElement(Config::get('watch_function')),
                'pr_stock'=>$faker->randomDigit(),
                'pr_description'=>$faker->text($maxNBChars=170),
                'pr_image'=>$faker->imageUrl($width=540,height:380),
                'is_active'=>$faker->randomElement(['1','0'])

        ]);

        }
    }
}
