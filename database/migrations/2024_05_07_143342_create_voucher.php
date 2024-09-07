<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('voucher', function (Blueprint $table) {
            $table->id();
            $table->double('dongiatoithieu')->default(0);
            $table->string('ma');
            $table->dateTime('ngaytao');
            $table->dateTime('ngayhethan');
            $table->double('sotiengiam');
            $table->integer('solansudung');
            $table->integer('solandadung')->default(0);
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher');
    }
};
