<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->integer('code');
            $table->unsignedBigInteger('user_id');
            $table->string('status');
            $table->double('totalMoney');
            $table->string('customerName');
            $table->string('phone');
            $table->string('address');
            $table->string('paymentMethod');
            $table->dateTime('orderDate');
            $table->dateTime('recivedDate')->nullable();
            $table->string('cancelReson')->nullable();
            $table->boolean('isCancel')->default(false);
            $table->unsignedBigInteger('voucher_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
