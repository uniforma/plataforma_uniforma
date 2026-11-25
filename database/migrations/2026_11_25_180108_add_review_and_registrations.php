<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teaching_interests', function (Blueprint $table) {
            $table->string('status')->default('pending')->index();
            $table->string('type')->nullable();
            $table->text('review_notes')->nullable();
        });

        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submissao_id')
                ->constrained('submissoes')
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['submissao_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');

        Schema::table('teaching_interests', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropColumn(['status', 'type', 'review_notes']);
        });
    }
};