
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Adiciona os campos da Proposta de Ministração.
     */
    public function up(): void
    {
        Schema::table('teaching_interests', function (Blueprint $table) {
            $table->unsignedInteger('carga_horaria')->nullable();

            $table->json('dias_semana')->nullable();

            $table->json('horarios')->nullable();

            $table->text('recursos')->nullable();

            $table->enum('modalidade', [
                'EAD',
                'HIBRIDO',
                'PRESENCIAL'
            ])->nullable();
        });
    }

    /**
     * Remove os campos caso a migration seja revertida.
     */
    public function down(): void
    {
        Schema::table('teaching_interests', function (Blueprint $table) {
            $table->dropColumn([
                'carga_horaria',
                'dias_semana',
                'horarios',
                'recursos',
                'modalidade'
            ]);
        });
    }
};
