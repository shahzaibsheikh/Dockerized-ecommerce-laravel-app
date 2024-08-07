<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Brands;

class BrandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
       for($i=0;$i<6;$i++){
       	Brands::create([
         'name'=>"This is Brand name".$i,
         'location'=>"This is Brand location".$i,
         'description'=>"This is Brand description".$i
       	]);

       }

    }
}
