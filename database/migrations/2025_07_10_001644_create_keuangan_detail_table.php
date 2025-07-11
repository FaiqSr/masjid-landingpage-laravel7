<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeuanganDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keuangan_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('header_id');
            $table->date('tanggal_transaksi');
            $table->string('keterangan');
            $table->enum('tipe', ['D', 'K'])->comment('D=Debet (Masuk), K=Kredit (Keluar)');
            $table->decimal('nilai', 15, 2);
            $table->timestamps();

            // Definisi Foreign Key Constraint
            $table->foreign('header_id')
                ->references('id')
                ->on('keuangan_header')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keuangan_detail');
    }
}
