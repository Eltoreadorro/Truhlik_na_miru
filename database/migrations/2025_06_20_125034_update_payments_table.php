<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            // Переименуем payment_method в method (если нужно)
            $table->renameColumn('payment_method', 'method');

            // Или если колонка method вообще отсутствует:
            // $table->string('method')->after('amount');

            // Добавим другие недостающие поля
            $table->string('variable_symbol')->nullable()->after('status');
            $table->text('details')->nullable()->after('variable_symbol');
        });
    }

    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->renameColumn('method', 'payment_method');
            // Или если добавляли новую колонку:
            // $table->dropColumn('method');

            $table->dropColumn(['variable_symbol', 'details']);
        });
    }
}
