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
        Schema::create('company_information', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('phone', 20)->nullable();
            $table->string('email')->nullable();
            $table->json('entity_keys')->nullable();

            $table->string('address')->nullable();

            $table->foreignUuid('company_id')->references('id')->on('companies')->cascadeOnDelete();

            $table->char('department_id', 2)->index();
            $table->foreign('department_id')->references('id')->on('departments');
            $table->char('province_id', 4)->index();
            $table->foreign('province_id')->references('id')->on('provinces');
            $table->char('district_id', 6)->index();
            $table->foreign('district_id')->references('id')->on('districts');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_information');
    }
};
