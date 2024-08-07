<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Dealers;

class DealersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

         for($i=0;$i<6;$i++){
       	Dealers::create([
         'brand_id'=>$i,
         'name'=>"This is Dealer name".$i,
         'location'=>"This is Dealer location".$i,
         'description'=>"This is Dealer description".$i
       	]);

       }
    }
}
