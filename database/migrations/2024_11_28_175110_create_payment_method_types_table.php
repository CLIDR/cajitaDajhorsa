<?php

use Illuminate\Support\Facades\DB;
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
        Schema::create('payment_method_types', function (Blueprint $table) {
            $table->id();

            $table->string('description');
            $table->boolean('has_card')->default(false);

            $table->timestamps();
        });

        DB::table('payment_method_types')->insert([
            ['id' => '1', 'description' => 'Efectivo'          , 'has_card' => false],
            ['id' => '2', 'description' => 'Tarjeta de crédito', 'has_card' => true],
            ['id' => '3', 'description' => 'Tarjeta de débito',  'has_card' => true],
            ['id' => '4', 'description' => 'Transferencia',      'has_card' => false],
            ['id' => '5', 'description' => 'Yape',      'has_card' => false],
            ['id' => '6', 'description' => 'Plin',      'has_card' => false],
            ['id' => '7', 'description' => 'Otros medios de pago',      'has_card' => false],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_method_types');
    }
};
