<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeRepository extends Command
{
    protected $signature = 'make:repository {name}';
    protected $description = 'Create a new repository class';

    public function handle()
    {
        $name = Str::studly($this->argument('name'));
        $path = app_path("Repositories/{$name}Repository.php");

        if (File::exists($path)) {
            $this->error("Repository already exists.");
            return;
        }

        if (!File::isDirectory(app_path('Repositories'))) {
            File::makeDirectory(app_path('Repositories'));
        }

        File::put($path, <<<PHP
<?php

namespace App\Repositories;

use App\Models\\{$name};

class {$name}Repository
{
    public function create(array \$data): {$name}
    {
        return {$name}::create(\$data);
    }
}
PHP);

        $this->info("Repository created: {$path}");
    }
}
