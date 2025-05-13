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

Schema::table('orders', function (Blueprint $table) {

$table->string('status')->default('new');

$table->string('payment_method');

$table->string('payment_status')->default('pending');

$table->decimal('deposit_amount', 10, 2)->nullable();

$table->text('notes')->nullable();

$table->dropColumn('items');

});

}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
