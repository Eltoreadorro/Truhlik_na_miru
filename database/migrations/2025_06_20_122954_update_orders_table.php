<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('email')->nullable()->after('phone');
            $table->string('delivery_method')->after('address');
            $table->string('variable_symbol')->nullable()->after('payment_status');
            $table->string('ip_address')->nullable()->after('notes');
            $table->text('user_agent')->nullable()->after('ip_address');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['email', 'delivery_method', 'variable_symbol', 'ip_address', 'user_agent']);
        });
    }
}
