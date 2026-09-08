<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeRepositoryCommand extends Command
{
    // O comando que você vai digitar no terminal
    protected $signature = 'make:repository {name}';

    protected $description = 'Cria uma Interface e um Repository de Eloquent';

    public function handle()
    {
        $name = $this->argument('name'); // Ex: User

        $interfaceName = "{$name}RepositoryInterface";
        $repositoryName = "{$name}Repository";

        // Caminhos dos arquivos
        $interfacePath = app_path("Repositories/Contracts/{$interfaceName}.php");
        $repositoryPath = app_path("Repositories/Eloquent/{$repositoryName}.php");

        // Garante que os diretórios existam
        File::makeDirectory(app_path('Repositories/Contracts'), 0755, true, true);
        File::makeDirectory(app_path('Repositories/Eloquent'), 0755, true, true);

        // 1. Conteúdo da Interface
        $interfaceContent = "<?php\n\nnamespace App\Repositories\Contracts;\n\ninterface {$interfaceName}\n{\n    // Declare os métodos aqui\n}\n";

        // 2. Conteúdo do Repository
        $repositoryContent = "<?php\n\nnamespace App\Repositories\Eloquent;\n\nuse App\Repositories\Contracts\\{$interfaceName};\n\nclass {$repositoryName} implements {$interfaceName}\n{\n    // Implemente a lógica aqui\n}\n";

        // Cria os arquivos
        File::put($interfacePath, $interfaceContent);
        File::put($repositoryPath, $repositoryContent);

        $this->info("Interface {$interfaceName} e Repositório {$repositoryName} criados com sucesso!");
    }
}