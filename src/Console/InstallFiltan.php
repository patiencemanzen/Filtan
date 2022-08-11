<?php

    namespace Patienceman\Filtan\Console;

    use Illuminate\Console\Command;
    use Illuminate\Support\Str;

    class InstallFiltan extends Command {
         /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'make:filter {name}';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Create your cutom model filters';

        /**
         * Create a new command instance.
         *
         * @return void
         */
        public function __construct() {
            parent::__construct();
        }

        /**
         * Execute the console command.
         *
         * @return int
         */
        public function handle() {
            $name = $this->argument('name');
            $dir = "./app/Services/Filters";
            $filename = $dir."/{$name}.php";

            if (!file_exists(dirname($filename)))
                mkdir(dirname($filename), 0777, true);

            fopen($filename, "w");

            $namespace = str_replace("/", "\\", Str::studly(
                dirname(str_replace(array("./"), "", $filename)
            )));

            file_put_contents(
                $filename,
                $this->getFileInitialContents($namespace, basename($filename, ".php"))
            );

            $this->info("{$namespace} create successfully");
        }

/**
 * Get file inital contents
 */
public function getFileInitialContents($namespace, $className) {
    $query = '$query';
    $builder = '$this->builder->where';

    return "<?php
    namespace $namespace;

    use Patienceman\Filtan\QueryFilter;

    class {$className} extends QueryFilter {
        /**
         * public function query($query) {
         *     $builder('name', 'LIKE', '%' .  . '%')
         * }
         */
    }
    ";
}
    }
