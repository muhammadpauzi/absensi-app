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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description', 500);
            $table->time('start_time'); // mulai absen masuk
            $table->time('batas_start_time'); // akhir absen masuk
            $table->time('end_time'); // mulai absen pulang
            $table->time('batas_end_time'); // akhir absen pulang
            $table->string('code')->nullable(); // for qrcode kalau kosong berarti hanya pakai button
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
        Schema::dropIfExists('attendances');
    }
};
