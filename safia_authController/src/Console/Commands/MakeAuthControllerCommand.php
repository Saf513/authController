<?php

namespace safia\authcontroller;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

// Add Laravel to your project if not already installed
// composer require laravel/framework

class MakeAuthControllerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:auth-controller {name=AuthController : The name of the controller}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new authentication controller with validation requests';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $controllerName = $this->argument('name');

        $this->makeController($controllerName);
        $this->makeLoginRequest();
        $this->makeRegisterRequest();

        $this->info('Authentication controller and requests created successfully!');

        return Command::SUCCESS;
    }

    /**
     * Create a new controller file.
     */
    protected function makeController(string $name): void
    {
        $controllerNamespace = 'App\\Http\\Controllers';
        $controllerPath = app_path('Http/Controllers/' . $name . '.php');

        $this->makeDirectory($controllerPath);

        $stub = $this->files->get(__DIR__ . '/stubs/controller.stub');

        $stub = str_replace(
            ['{{ namespace }}', '{{ class }}'],
            [$controllerNamespace, $name],
            $stub
        );

        $this->files->put($controllerPath, $stub);

        $this->info('Controller created: ' . $controllerPath);
    }

    /**
     * Create a new login request file.
     */
    protected function makeLoginRequest(): void
    {
        $requestNamespace = 'App\\Http\\Requests\\Auth';
        $requestPath = \app_path('Http/Requests/Auth/LoginRequest.php');

        $this->makeDirectory($requestPath);

        $stub = $this->files->get(__DIR__ . '/stubs/login-request.stub');

        $stub = str_replace(
            ['{{ namespace }}'],
            [$requestNamespace],
            $stub
        );

        $this->files->put($requestPath, $stub);

        $this->info('Login request created: ' . $requestPath);
    }

    /**
     * Create a new register request file.
     */
    protected function makeRegisterRequest(): void
    {
        $requestNamespace = 'App\\Http\\Requests\\Auth';
        $requestPath = app_path('Http/Requests/Auth/RegisterRequest.php');

        $this->makeDirectory($requestPath);

        $stub = $this->files->get(__DIR__ . '/stubs/register-request.stub');

        $stub = str_replace(
            ['{{ namespace }}'],
            [$requestNamespace],
            $stub
        );

        $this->files->put($requestPath, $stub);

        $this->info('Register request created: ' . $requestPath);
    }

    /**
     * Build the directory for the class if necessary.
     */
    protected function makeDirectory(string $path): string
    {
        $directory = dirname($path);

        if (! $this->files->isDirectory($directory)) {
            $this->files->makeDirectory($directory, 0777, true, true);
        }

        return $directory;
    }
}

