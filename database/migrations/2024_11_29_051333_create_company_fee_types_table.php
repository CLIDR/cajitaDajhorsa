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
        Schema::create('company_fee_types', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->boolean('is_recurrent')->default(true);
            $table->timestamps();
        });

        DB::table('company_fee_types')->insert([
            ['description' => 'MENSUAL', 'is_recurrent' => true],
            ['description' => 'ANUAL', 'is_recurrent' => false],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_fee_types');
    }
};
