<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sensor_id')->constrained('sensors')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('tipo_alerta');
            $table->text('mensaje');
            $table->boolean('atendida')->default(false);
            $table->timestamp('generado_en')->useCurrent();
            $table->timestamps();
        });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('alerts');
    }
};