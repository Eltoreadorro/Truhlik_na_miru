<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mail_logs', function (Blueprint $table) {
            $table->id();
            $table->string('to');              // Получатель
            $table->string('subject');         // Тема письма
            $table->text('body')->nullable();   // HTML-содержимое
            $table->string('status')->default('sent'); // Статус: sent, failed
            $table->text('error')->nullable(); // Ошибка (если была)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mail_logs');
    }
};
