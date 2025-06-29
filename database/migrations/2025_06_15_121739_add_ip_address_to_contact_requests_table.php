<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('contact_requests', function (Blueprint $table) {
            $table->string('ip_address')->nullable()->after('details');
        });
    }

    public function down()
    {
        Schema::table('contact_requests', function (Blueprint $table) {
            $table->dropColumn('ip_address');
        });
    }
};
