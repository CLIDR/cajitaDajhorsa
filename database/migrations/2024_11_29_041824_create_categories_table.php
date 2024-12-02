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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre de la categoría
            $table->enum('type', ['income', 'expense', 'fee', 'other']); // Tipo de categoría
            $table->string('context')->nullable(); // Contexto de uso (ej.: 'transactions', 'products', etc.)
            $table->text('description')->nullable(); // Descripción opcional
            $table->timestamps();
        });

        // Crear categorías de ingresos
        $incomeCategories = [
            ['name' => 'Ventas de Productos', 'type' => 'income', 'context' => 'transactions', 'description' => 'Ingresos derivados de la venta de productos físicos o digitales.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Servicios Profesionales', 'type' => 'income', 'context' => 'transactions', 'description' => 'Ingresos por servicios de consultoría, asesoría contable, legal, etc.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Alquiler de Bienes', 'type' => 'income', 'context' => 'transactions', 'description' => 'Ingresos derivados del alquiler de propiedades, equipos o espacios.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Comisiones', 'type' => 'income', 'context' => 'transactions', 'description' => 'Ingresos obtenidos por referir clientes o ventas.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Intereses y Dividendos', 'type' => 'income', 'context' => 'transactions', 'description' => 'Ingresos generados por inversiones financieras.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Subvenciones y Ayudas', 'type' => 'income', 'context' => 'transactions', 'description' => 'Ingresos provenientes de subvenciones gubernamentales o privadas.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Otros Ingresos Operacionales', 'type' => 'income', 'context' => 'transactions', 'description' => 'Otros tipos de ingresos recurrentes pero no operacionales.', 'created_at' => now(), 'updated_at' => now()],
        ];

        // Crear categorías de gastos
        $expenseCategories = [
            ['name' => 'Compra de Insumos', 'type' => 'expense', 'context' => 'transactions', 'description' => 'Gastos relacionados con la adquisición de materiales necesarios para producir bienes o servicios.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Salarios y Sueldos', 'type' => 'expense', 'context' => 'transactions', 'description' => 'Pagos a empleados o colaboradores.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Honorarios Profesionales', 'type' => 'expense', 'context' => 'transactions', 'description' => 'Gastos derivados de la contratación de servicios de terceros, como contadores, abogados, consultores.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mantenimiento y Reparaciones', 'type' => 'expense', 'context' => 'transactions', 'description' => 'Gastos asociados a la conservación y reparación de activos.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Servicios Públicos', 'type' => 'expense', 'context' => 'transactions', 'description' => 'Gastos en electricidad, agua, teléfono, internet, etc.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Publicidad y Marketing', 'type' => 'expense', 'context' => 'transactions', 'description' => 'Gastos relacionados con la promoción de la empresa, campañas publicitarias, redes sociales.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Gastos Financieros', 'type' => 'expense', 'context' => 'transactions', 'description' => 'Gastos derivados de intereses de préstamos, tarjetas de crédito, etc.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Otros Gastos Operacionales', 'type' => 'expense', 'context' => 'transactions', 'description' => 'Cualquier otro gasto recurrente relacionado con la operación diaria de la empresa.', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('categories')->insert([
            ['name' => 'Honorarios Mensuales', 'type' => 'fee', 'context' => 'transactions', 'description' => 'Ingresos recurrentes por servicios mensuales.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Honorarios Anuales', 'type' => 'fee', 'context' => 'transactions', 'description' => 'Ingresos anuales por servicios especializados o balance de cuentas.', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Insertar categorías en la base de datos
        DB::table('categories')->insert(array_merge($incomeCategories, $expenseCategories));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
