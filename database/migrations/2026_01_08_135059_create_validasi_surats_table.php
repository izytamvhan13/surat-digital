<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('validasi_surats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_masuk_id')->constrained('surat_masuk')->onDelete('cascade');
            
            $table->foreignId('validator_id')->constrained('users');
            
            $table->enum('status', ['disetujui', 'ditolak', 'revisi']);
            $table->text('catatan_validasi')->nullable(); 
            $table->date('tanggal_validasi');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validasi_surats');
    }
};
