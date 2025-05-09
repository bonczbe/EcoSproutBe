<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeService extends Command
{
    protected $signature = 'make:service {name}';

    protected $description = 'Create a new service class';

    public function handle()
    {
        $name = Str::studly($this->argument('name'));
        $path = app_path("Services/{$name}Service.php");

        if (File::exists($path)) {
            $this->error('Service already exists.');

            return;
        }

        if (! File::isDirectory(app_path('Services'))) {
            File::makeDirectory(app_path('Services'));
        }

        File::put($path, <<<PHP
<?php

namespace App\Services;

use App\DTOs\\{$name}DTO;
use App\Repositories\\{$name}Repository;
use Illuminate\Support\Facades\Hash;

class {$name}Service
{
    public function __construct(
        protected {$name}Repository \$repository
    ) {}

    public function register({$name}DTO \$dto)
    {
        return \$this->repository->create([
            'name' => \$dto->name,
            'email' => \$dto->email,
            'password' => Hash::make(\$dto->password),
        ]);
    }
}
PHP);

        $this->info("Service created: {$path}");
    }
}
