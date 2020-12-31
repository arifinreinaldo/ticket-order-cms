<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CrudGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:generator {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');

        if (substr($name, 0, 1) == 'M' || substr($name, 0, 1) == 'T') {
            $table_name = $name;
            $second_char = substr($name, 1, 1);
            if (ctype_upper($second_char)) {
                $table_name = substr($name, 0, 1) . '_' . substr($name, 1);
            }
            $this->controller($name);
            $this->model($name);
//            $this->request($name);
            $this->blade($name);

            File::append(base_path('routes/web.php'), 'Route::get(\'/' . strtolower($name) . "','{$name}Controller@webIndex')->name('" . strtolower($name) . "');");
            File::append(base_path('routes/web.php'), 'Route::post(\'/' . strtolower($name) . "/store','{$name}Controller@webStore');");
            File::append(base_path('routes/web.php'), 'Route::post(\'/' . strtolower($name) . "/update','{$name}Controller@webUpdate');");
            File::append(base_path('routes/web.php'), 'Route::post(\'/' . strtolower($name) . "/destroy','{$name}Controller@webDestroy');");
            File::append(base_path('routes/web.php'), 'Route::post(\'/' . strtolower($name) . "/edit/{id}','{$name}Controller@webEdit');");
            File::append(base_path('routes/web.php'), 'Route::post(\'/' . strtolower($name) . "/toggle','{$name}Controller@webToggle');");
            File::append(base_path('routes/web.php'), 'Route::get(\'/' . strtolower($name) . "/ajaxData','{$name}Controller@ajaxData')->name('" . strtolower($name) . "/ajaxData');");


//            Artisan::call('make:migration create_' . strtolower(Str::plural($name)) . '_table --create=' . strtolower(Str::plural($table_name)));
        } else {
            echo 'Invalid Format';
        }

    }

    public function getStub($type)
    {
        return file_get_contents(resource_path("stubs/$type.stub"));
    }

    protected function model($name)
    {
        $modelTemplate = str_replace('{{modelName}}', $name, $this->getStub('Model'));
        file_put_contents(app_path("/{$name}.php"), $modelTemplate);
    }

    protected function request($name)
    {
        $requestTemplate = str_replace('{{modelName}}', $name, $this->getStub('Request'));

        if (!file_exists($path = app_path('/Http/Requests'))) {
            mkdir($path, 0777, true);
        }

        file_put_contents(app_path("/Http/Requests/{$name}Request.php"), $requestTemplate);
    }

    protected function controller($name)
    {
        $requestTemplate = str_replace(['{{modelName}}', '{{modelNamePluralLowerCase}}', '{{modelNameSingularLowerCase}}'], [$name, strtolower(Str::plural($name)), strtolower($name)], $this->getStub('Controller'));

        if (!file_exists($path = app_path('/Http/Controllers'))) {
            mkdir($path, 0777, true);
        }

        file_put_contents(app_path("/Http/Controllers/{$name}Controller.php"), $requestTemplate);
    }

    protected function blade($name)
    {
        $requestTemplate = str_replace(['{{modelName}}', '{{modelNamePluralLowerCase}}', '{{modelNameSingularLowerCase}}'], [$name, strtolower(Str::plural($name)), strtolower($name)], $this->getStub('Blade'));

        if (!file_exists($path = resource_path('/views/master'))) {
            mkdir($path, 0777, true);
        }

        $lower_name = strtolower($name);

        file_put_contents(resource_path("/views/master/{$lower_name}.blade.php"), $requestTemplate);
    }
}
