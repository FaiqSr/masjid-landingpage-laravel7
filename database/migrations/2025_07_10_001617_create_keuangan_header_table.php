<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeuanganHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keuangan_header', function (Blueprint $table) {
            $table->id(); // Sesuai dengan `int UNSIGNED NOT NULL AUTO_INCREMENT, PRIMARY KEY`
            $table->date('periode');
            $table->string('akun');
            $table->string('keterangan')->nullable();
            $table->decimal('saldo_awal', 15, 2)->default(0.00);
            $table->decimal('total_debet', 15, 2)->default(0.00);
            $table->decimal('total_kredit', 15, 2)->default(0.00);
            $table->decimal('saldo_akhir', 15, 2)->default(0.00);
            $table->timestamps(); // Sesuai dengan `created_at` dan `updated_at`
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keuangan_header');
    }
}
