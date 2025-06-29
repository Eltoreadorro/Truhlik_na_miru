<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('tracking_number')->nullable()->after('payment_status');
            $table->date('estimated_delivery_date')->nullable()->after('tracking_number');
            $table->string('delivery_service')->nullable()->after('delivery_method');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['tracking_number', 'estimated_delivery_date', 'delivery_service']);
        });
    }
};
