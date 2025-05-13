<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Имя файла
            $table->string('file_path'); // Путь к файлу
            $table->string('model_type'); // Класс модели
            $table->unsignedBigInteger('model_id'); // ID модели
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('media');
    }
};


    /**
     * Reverse the migrations.
     */
