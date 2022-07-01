<?php

use App\Models\Producto;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();

            $table->string('barcode');
            $table->string('name');
            $table->string('description');
            $table->string('key_product');
            $table->integer('stock');
            $table->float('cost');
            $table->float('price');
            $table->enum('status', [Producto::Activo, Producto::Inactivo])->default(Producto::Inactivo);

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
        Schema::dropIfExists('productos');
    }
}
