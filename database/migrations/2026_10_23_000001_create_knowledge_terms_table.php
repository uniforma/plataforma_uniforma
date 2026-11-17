<?php

use App\Models\KnowledgeTerm;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('knowledge_terms', function (Blueprint $table) {
            $table->id();
            $table->string('kind', 20);
            $table->string('name');
            $table->timestamps();
            $table->unique(['kind', 'name']);
        });

        // Bring existing profiles and demands into the shared uppercase catalog.
        $remember = function (string $kind, string $value): string {
            $name = KnowledgeTerm::normalize($value);
            if ($name !== '') {
                DB::table('knowledge_terms')->insertOrIgnore(['kind' => $kind, 'name' => $name, 'created_at' => now(), 'updated_at' => now()]);
            }

            return $name;
        };

        DB::table('users')->orderBy('id')->chunkById(100, function ($users) use ($remember) {
            foreach ($users as $user) {
                $skills = collect(json_decode($user->skills ?? '[]', true) ?: [])->map(fn ($name) => $remember('skill', (string) $name))->filter()->unique()->values()->all();
                $areas = collect(json_decode($user->knowledge_areas ?? '[]', true) ?: [])->map(fn ($name) => $remember('area', (string) $name))->filter()->unique()->values()->all();
                DB::table('users')->where('id', $user->id)->update(['skills' => json_encode($skills), 'knowledge_areas' => json_encode($areas)]);
            }
        });

        DB::table('submissoes')->orderBy('id')->chunkById(100, function ($submissions) use ($remember) {
            foreach ($submissions as $submission) {
                DB::table('submissoes')->where('id', $submission->id)->update(['knowledge_field' => $remember('area', $submission->knowledge_field)]);
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('knowledge_terms');
    }
};
