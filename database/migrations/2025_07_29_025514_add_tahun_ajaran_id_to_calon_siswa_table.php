<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTahunAjaranIdToCalonSiswaTable extends Migration
{
    public function up()
    {
        Schema::table('calon_siswa', function (Blueprint $table) {
            $table->foreignId('id_tahun_ajaran')
                  ->after('id_jalur_pendaftaran')
                  ->constrained('tahun_ajaran', 'id_tahun_ajaran')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('calon_siswa', function (Blueprint $table) {
            $table->dropForeign(['id_tahun_ajaran']);
            $table->dropColumn('id_tahun_ajaran');
        });
    }
}