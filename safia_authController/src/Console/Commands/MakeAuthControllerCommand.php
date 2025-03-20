<?php

namespace Safia\Authcontroller\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class MakeAuthControllerCommand extends Command
{
    protected $signature = 'make:auth-controller {name=AuthController}';
    protected $description = 'Create an authentication controller with register and login methods';

    protected $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    public function handle()
    {
        $name = $this->argument('name');
        $path = app_path('Http/Controllers/' . $name . '.php');

        if ($this->files->exists($path)) {
            $this->error('Controller already exists!');
            return;
        }

        $this->makeDirectory(dirname($path));
        $this->files->put($path, $this->buildClass($name));

        $this->info($name . ' created successfully.');
    }

    protected function buildClass($name)
    {
        $stub = $this->files->get(__DIR__ . '/../../stubs/auth-controller.stub');

        $namespace = app()->getNamespace() . 'Http\\Controllers';
        $class = $name;

        $stub = str_replace('{{namespace}}', $namespace, $stub);
        $stub = str_replace('{{class}}', $class, $stub);

        return $stub;
    }

    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0755, true, true);
        }

        return $path;
    }
}