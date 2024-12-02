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
        Schema::create('company_fees', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('date');
            $table->string('description');
            $table->text('observation')->nullable();
            $table->decimal('amount', 8, 2)->default(0);
            $table->enum('status', ['PAID', 'PARTIAL', 'PENDING', 'NULLED']);
            $table->string('document_reference')->nullable();

            $table->foreignUuid('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_fees');
    }
};
