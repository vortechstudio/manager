<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateEnumCommand extends Command
{
    protected $signature = 'enum:generate';

    protected $description = 'Command description';

    public function handle(): void
    {
        $models = $this->getModelClasses(app_path('Models'));

        $enumClassContent = "<?php\n".
            "\n".
            "namespace App\\Enums;\n".
            "\n".
            "enum ModelTypes: string\n".
            "{\n";

        foreach ($models as $model) {
            $modelBaseName = class_basename($model);
            $enumClassContent .= '    case '.strtoupper($modelBaseName)." = '".$model."';\n";
        }

        $enumClassContent .= "}\n";

        file_put_contents(app_path('Enums/ModelTypes.php'), $enumClassContent);

        $this->info('Enum class created successfully.');
    }

    protected function getModelClasses($path)
    {
        $files = scandir($path);
        $classes = [];

        foreach ($files as $file) {
            if (in_array($file, ['.', '..'])) {
                continue;
            }
            $filePath = $path.'/'.$file;
            if (is_dir($filePath)) {
                $classes = array_merge($classes, $this->getModelClasses($filePath));
            }

            if (is_file($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) == 'php') {
                $classes[] = 'App\\Models\\'.str_replace('/', '\\', Str::before(Str::after($filePath, app_path('Models/')), '.php'));
            }
        }

        return $classes;
    }
}
