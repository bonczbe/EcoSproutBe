<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeDTO extends Command
{
    protected $signature = 'make:dto {name}';
    protected $description = 'Create a new Data Transfer Object (DTO)';

    public function handle()
    {
        $name = Str::studly($this->argument('name'));
        $path = app_path("DTOs/{$name}DTO.php");

        if (File::exists($path)) {
            $this->error("DTO {$name}DTO already exists.");
            return;
        }

        if (!File::isDirectory(app_path('DTOs'))) {
            File::makeDirectory(app_path('DTOs'));
        }

        File::put($path, <<<PHP
<?php

namespace App\DTOs;

class {$name}DTO
{
    public function __construct(
        public readonly string \$name,
        public readonly string \$email,
        public readonly string \$password,
    ) {}

    public static function fromRequest(\\Illuminate\\Http\\Request \$request): self
    {
        return new self(
            name: \$request->input('name'),
            email: \$request->input('email'),
            password: \$request->input('password'),
        );
    }
}
PHP);

        $this->info("DTO created: {$path}");
    }
}
