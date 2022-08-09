<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_transaksi', function (Blueprint $table) {
            $table->id();
            $table->tinyText('catatan');
            $table->decimal('total_uang', $precision = 15, $scale = 2);
            $table->date('tanggal_transaksi');
            $table->foreignId('kategori_id')->constrained('kategori')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('data_transaksi');
    }
}
