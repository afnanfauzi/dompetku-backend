<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHutangPiutangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hutang_piutang', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_transaksi');
            $table->decimal('total_uang', $precision = 15, $scale = 2);
            $table->tinyText('catatan')->nullable();
            $table->tinyInteger('jenis')->comment('0 = Hutang, 1 = Piutang');
            $table->foreignId('mitra_id')->constrained('mitra')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('hutang_piutang');
    }
}
