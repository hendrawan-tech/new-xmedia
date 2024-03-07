<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_metas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nik');
            $table->string('phone');
            $table->string('address');
            $table->string('rt');
            $table->string('rw');
            $table->string('longlat');
            $table->string('province_id');
            $table->string('province_name');
            $table->string('regencies_id');
            $table->string('regencies_name');
            $table->string('district_id');
            $table->string('district_name');
            $table->string('ward_id');
            $table->string('ward_name');
            $table->string('xmedia_id');
            $table->unsignedBigInteger('package_id');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_metas');
    }
};
