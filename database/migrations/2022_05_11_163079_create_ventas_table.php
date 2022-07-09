<?php

use App\Models\Venta;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();

            $table->float('costo');
            $table->float('total');
            $table->float('ganancia');
            $table->float('efectivo');
            $table->float('debito');
            $table->float('credito');
            $table->float('recibido');
            $table->float('cambio');

            $table->json('content');

            $table->enum('facturable', [Venta::Facturable, Venta::Nofacturable])->default(Venta::Facturable);
            $table->enum('typePayment', [Venta::Efectivo, Venta::Credito, Venta::Debito]);

            $table->boolean('facturado')->default(false);

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

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
        Schema::dropIfExists('ventas');
    }
}
