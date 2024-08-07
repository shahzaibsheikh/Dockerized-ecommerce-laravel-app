<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id');
            $table->string('pr_name');
            $table->double('pr_price')->default(0);
            $table->double('pr_sale_price')->default(0);
            $table->string('pr_color')->nullable();
            $table->string('pr_code')->nullable(); 
            $table->string('pr_gender')->nullable();
            $table->string('pr_function')->nullable();
            $table->integer('pr_stock')->default(0);
            $table->string('pr_description')->nullable();
            $table->string('pr_image')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
