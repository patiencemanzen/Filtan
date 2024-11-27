<?php

    namespace Patienceman\Filtan\Console;

    use Illuminate\Console\Command;
    use Illuminate\Filesystem\Filesystem;
    use Illuminate\Support\Str;

    class CreateFiltersCommand extends Command {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'filtan:create {filter} {--model=}';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Create your cutom Query Filters';

        /**
         * The base directory for the filters.
         *
         * @var string
         */
        protected $directory;

        /**
         * The namespace for the filters.
         *
         * @var string
         */
        protected $namespace;

        /**
         * Create a new command instance.
         *
         * @return void
         */
        public function __construct() {
            parent::__construct();

            $baseDirectory = app_path(config('filtan.filtan_folder')) . '/' . config('filtan.filters_folder_name');
            $namespace = 'App\\' . config('filtan.filtan_folder') . '\\' . config('filtan.filters_folder_name');

            $this->directory = $baseDirectory;
            $this->namespace = $namespace;
        }

        /**
         * Execute the console command.
         *
         * @return int
         */
        public function handle() {
            $filter = $this->argument('filter');
            $modelName = $this->option('model');
            $pathInfo = pathinfo($filter);

            $directory = $this->getDirectory($pathInfo['dirname']);
            $filename = $this->getFilename($directory, $pathInfo['basename']);
            $namespace = $this->getNamespace($pathInfo['dirname']);

            $this->createDirectory($directory);

            $baseName = basename($filename, ".php");

            $this->writeFile($filename, $this->getFileInitialContents($namespace, $baseName));

            $this->info($filename . " Created successfully");

            if ($modelName) $this->appendFilterableTraitToModel($modelName);
        }

        /**
         * Get the directory path.
         *
         * @param string $this->directory
         * @param string $dirname
         * @return string
         */
        protected function getDirectory($dirname) {
            return empty($dirname) || $dirname == '.' ? $this->directory : $this->directory . '/' . $dirname;
        }

        /**
         * Get the full filename.
         *
         * @param string $directory
         * @param string $basename
         * @return string
         */
        protected function getFilename($directory, $basename) {
            return $directory. '/'. trim($basename) . '.php';
        }

        /**
         * Create the directory if it doesn't exist.
         *
         * @param string $directory
         * @return void
         */
        protected function createDirectory($directory) {
            if (!file_exists(rtrim($directory, '/'))) {
                mkdir($directory, 0777, true);
            }
        }

        /**
         * Get the namespace for the filter.
         *
         * @param string $directory
         * @return string
         */
        protected function getNamespace($dirname) {
            $namespace = empty($dirname) || $dirname == '.' 
                ? $this->namespace 
                : $this->namespace. '\\' . str_replace('/', '\\', $dirname);
                
            return rtrim($namespace, '\\');
        }

        /**
         * Write the initial contents to the file.
         *
         * @param string $filename
         * @param string $contents
         * @return void
         */
        protected function writeFile($filename, $contents) {
            file_put_contents($filename, $contents);
        }

        /** 
         * Get file initial contents
         *
         * @param string $namespace The namespace of the filter
         * @param string $className The class name of the filter
         * @return string The initial contents of the filter file
         */
        protected function getFileInitialContents($namespace, $className) {
            return "<?php
    namespace $namespace;

    use Patienceman\Filtan\QueryFilter;

    class $className extends QueryFilter {
        /**
         * Search specific values from model by name
         *
         * @param string \$query
         * @return void
         */
        public function query(string \$query) {
            \$this->builder->where('name', 'LIKE', '%' . \$query . '%');
        }
    }
    ";
        }

        /**
         * Append the Filterable trait to the specified model.
         *
         * @param string $modelName
         * @return void
         */
        protected function appendFilterableTraitToModel($modelName) {
            $filesystem = new Filesystem();
            $modelPath = $this->findModelPath($modelName);

            if ($modelPath && $filesystem->exists($modelPath)) {
                $modelContent = $filesystem->get($modelPath);

                if (strpos($modelContent, 'use Filterable;') === false) {
                    $modelContent = preg_replace(
                        '/(class\s+' . preg_quote(class_basename($modelName)) . '\s+extends\s+Model\s*\{)/',
                        "$1\n    use \\Patienceman\\Filtan\\Filterable;",
                        $modelContent
                    );

                    $filesystem->put($modelPath, $modelContent);
                    $this->info("Filterable trait added to model: " . $modelName);
                } else {
                    $this->info("Model already uses Filterable trait: " . $modelName);
                }
            } else {
                $this->error("Model not found: " . $modelName);
            }
        }

        /**
         * Find the path to the specified model.
         *
         * @param string $modelName
         * @return string|null
         */
        protected function findModelPath($modelName) {
            $filesystem = new Filesystem();
            $modelPath = base_path('app/' . str_replace('\\', '/', $modelName) . '.php');

            if ($filesystem->exists($modelPath)) {
                return $modelPath;
            }

            // Search recursively in the app directory
            $files = $filesystem->allFiles(base_path('app\\Models'));
            foreach ($files as $file) {
                if (strpos($file->getRealPath(), str_replace('\\', '/', $modelName) . '.php') !== false) {
                    return $file->getRealPath();
                }
            }

            return null;
        }
    }
