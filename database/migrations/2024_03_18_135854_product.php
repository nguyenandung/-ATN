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
         Schema::create('Products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('name');
            $table->string('description');
            $table->double('price');
            $table->integer('stock');
            $table->string('slug') ;
            // $table->string('defaultImage');
            // $table->json('listImage');
            $table->boolean('status')->default(true);
            $table->dateTime('create_at');
            $table->string('create_by');
            $table->dateTime('update_at')->nullable();
            $table->string('update_by')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Products');
    }
};
