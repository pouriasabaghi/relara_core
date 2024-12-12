<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeService extends Command
{
    // تعریف نام و توضیحات دستور
    protected $signature = 'make:service {name : The name of the service class}';
    protected $description = 'Create a new service class';

    public function handle()
    {
        // get class name
        $name = $this->argument('name');

        // change name to namespace
        $classPath = str_replace('\\', '/', $name);
        $namespace = 'App\\Services\\' . str_replace('/', '\\', $classPath);
        $fileName = class_basename($name); // نام فایل کلاس
        $directoryPath = app_path('Services/' . dirname($classPath));

        // final path 
        $filePath = "{$directoryPath}/{$fileName}.php";

        // if service doesn't exists
        if (File::exists($filePath)) {
            $this->error("Service {$name} already exists!");
            return 1;
        }

        // if directory doesn't exists
        if (!File::isDirectory($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true);
        }

        // service file content
        $stub = <<<PHP
        <?php
            
        namespace {$namespace};
            
        class {$fileName}
        {
            // Add your service methods here
        }
        PHP;

        // create file
        File::put($filePath, $stub);

        // success message
        $this->send("Service {$filePath} created successfully.");
        return 0;
    }
}
