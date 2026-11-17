<?php

namespace Database\Seeders;

use App\Models\KnowledgeTerm;
use App\Models\Submissao;
use App\Models\User;
use Illuminate\Database\Seeder;

class KnowledgeTermSeeder extends Seeder
{
    public function run(): void
    {
        KnowledgeTerm::remember(KnowledgeTerm::AREA, [
            'CIÊNCIAS AGRÁRIAS', 'CIÊNCIAS BIOLÓGICAS', 'CIÊNCIAS DA SAÚDE',
            'CIÊNCIAS EXATAS E DA TERRA', 'CIÊNCIAS HUMANAS', 'CIÊNCIAS SOCIAIS APLICADAS',
            'EDUCAÇÃO', 'ENGENHARIAS', 'GESTÃO', 'LINGUÍSTICA, LETRAS E ARTES',
            'TECNOLOGIA DA INFORMAÇÃO', 'MULTIDISCIPLINAR',
        ]);

        KnowledgeTerm::remember(KnowledgeTerm::SKILL, [
            'ANÁLISE DE DADOS', 'ATENDIMENTO AO PÚBLICO', 'COMUNICAÇÃO',
            'DESENVOLVIMENTO DE SOFTWARE', 'DOCÊNCIA', 'ESCRITA ACADÊMICA',
            'EXTENSÃO UNIVERSITÁRIA', 'FACILITAÇÃO DE GRUPOS', 'GESTÃO DE PROJETOS',
            'IDIOMAS', 'INFORMÁTICA', 'METODOLOGIA CIENTÍFICA',
            'ORGANIZAÇÃO DE EVENTOS', 'PESQUISA', 'PLANEJAMENTO',
            'PRODUÇÃO DE CONTEÚDO', 'TRABALHO EM EQUIPE',
            'ACESSIBILIDADE DIGITAL', 'ADMINISTRAÇÃO PÚBLICA', 'ANÁLISE ESTATÍSTICA',
            'APRESENTAÇÕES ORAIS', 'AVALIAÇÃO EDUCACIONAL', 'BIBLIOTECONOMIA',
            'CAPTAÇÃO DE RECURSOS', 'COMUNICAÇÃO CIENTÍFICA', 'CRIAÇÃO DE MATERIAL DIDÁTICO',
            'DESIGN GRÁFICO', 'DIDÁTICA', 'EDUCAÇÃO A DISTÂNCIA',
            'EDUCAÇÃO INCLUSIVA', 'ELABORAÇÃO DE PROJETOS', 'ENSINO DE IDIOMAS',
            'EXCEL', 'FERRAMENTAS COLABORATIVAS', 'FOTOGRAFIA',
            'GESTÃO DE EQUIPES', 'GESTÃO DE PROCESSOS', 'GESTÃO FINANCEIRA',
            'INTELIGÊNCIA ARTIFICIAL', 'INTERPRETAÇÃO DE DADOS', 'LIBRAS',
            'MEDIAÇÃO DE CONFLITOS', 'MENTORIA', 'ORATÓRIA',
            'PESQUISA BIBLIOGRÁFICA', 'PLANEJAMENTO DE AULAS', 'PRIMEIROS SOCORROS',
            'PRODUÇÃO AUDIOVISUAL', 'PROGRAMAÇÃO', 'REDAÇÃO TÉCNICA',
            'REVISÃO DE TEXTOS', 'SEGURANÇA DA INFORMAÇÃO', 'TRATAMENTO DE IMAGENS',
            'USO DE PLANILHAS', 'VISUALIZAÇÃO DE DADOS', 'WEB DESIGN',
        ]);

        KnowledgeTerm::remember(KnowledgeTerm::AREA, Submissao::query()->pluck('knowledge_field'));
        User::query()->whereNotNull('skills')->orWhereNotNull('knowledge_areas')->get(['skills', 'knowledge_areas'])->each(function (User $user) {
            KnowledgeTerm::remember(KnowledgeTerm::SKILL, $user->skills ?? []);
            KnowledgeTerm::remember(KnowledgeTerm::AREA, $user->knowledge_areas ?? []);
        });
    }
}
