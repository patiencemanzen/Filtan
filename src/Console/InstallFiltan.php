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
        protected $description = 'Create your cutom Query Filters';

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
            // Get the name of the filter from the command argument
            $name = $this->argument('name');

            // Define the directory to store the filter file
            $dir = "./app/Http/QueryFilters";

            // Define the full file path
            $filename = $dir."/{$name}.php";

            // Create directory if it doesn't exist
            if (!file_exists(dirname($filename)))
                mkdir(dirname($filename), 0777, true);

            fopen($filename, "w");

            // Generate namespace for the filter
            $namespace = str_replace("/", "\\", Str::studly(
                dirname(str_replace(array("./"), "", $filename)
            )));
            
            // Extract the base name of the file
            $baseName = basename($filename, ".php");

            // Write initial contents to the filter file
            file_put_contents( $filename,
                $this->getFileInitialContents($namespace, $baseName)
            );

            $this->info($namespace."\\".$baseName." Created successfully");
        }

    /** 
     * Get file initial contents
     *
     * @param string $namespace The namespace of the filter
     * @param string $className The class name of the filter
     * @return string The initial contents of the filter file
     */
public function getFileInitialContents($namespace, $className) {
    $query = '$query';
    $builder = '$this->builder->where';

    // Initial contents of the filter file
    return "<?php
    namespace $namespace;

    use Patienceman\Filtan\QueryFilter;

    class {$className} extends QueryFilter {
        /**
         * Apply the filter to the query.
         *
         * @param  \\Illuminate\Database\Eloquent\Builder  \$query
         * @return \\Illuminate\Database\Eloquent\Builder
         */
        public function query(string \$query) {
            // Implement your filter logic here
            // Example: $builder('column_name', 'operator', 'value');
        }
    }
    ";
}
    }
