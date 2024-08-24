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
        Schema::create('exception_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('exception_type')->nullable();
            $table->text('message')->nullable();
            $table->integer('code')->nullable();
            $table->string('file')->nullable();
            $table->integer('line')->nullable();
            $table->longText('stack_trace')->nullable();
            $table->string('url')->nullable();
            $table->string('method')->nullable();
            $table->ipAddress('ip')->nullable();
            $table->json('request_data')->nullable();
            $table->json('headers')->nullable();
            $table->timestamps();
            

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exception_logs');
    }
};
