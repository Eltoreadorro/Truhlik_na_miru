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
    Schema::table('contact_requests', function (Blueprint $table) {
        // Переименовываем message в details или наоборот
        if (Schema::hasColumn('contact_requests', 'message')) {
            $table->renameColumn('message', 'details');
        } elseif (Schema::hasColumn('contact_requests', 'details')) {
            $table->renameColumn('details', 'message');
        }
    });
}

public function down()
{
    Schema::table('contact_requests', function (Blueprint $table) {
        // Обратное переименование для отката
        if (Schema::hasColumn('contact_requests', 'details')) {
            $table->renameColumn('details', 'message');
        } elseif (Schema::hasColumn('contact_requests', 'message')) {
            $table->renameColumn('message', 'details');
        }
    });
}
};
