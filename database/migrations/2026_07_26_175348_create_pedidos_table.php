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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estoque_id');
            $table->unsignedBigInteger('user_id');
            $table->datetime('date');
            $table->double('quantidade');
            $table->double('quantidade_entregue')->default(0);
            $table->enum('status', ['Pendente', 'Entregue', 'Cancelado']);
            $table->timestamps();
            $table->foreign('estoque_id')->references('id')->on('estoques');
            $table->foreign('user_id')->references('id')->on('users');
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
