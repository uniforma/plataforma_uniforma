<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('submissoes', function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
            $table->timestamps();
            $table->string('title');
            $table->text('background');
            $table->string('target_audience');
            $table->string('knowledge_field');
            $table->enum('status',['Em votação', 'Alta Relevancia','Em curadoria', 'Oficializado', 'Arquivado'])->default('Em votação');
            $table->foreignID('autor_id')->nullable()->constrained('users')->nullonDelete();
            $table->foreignID('curator_id')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('submissoes');
        Schema::enableForeignKeyConstraints();
    }
};
