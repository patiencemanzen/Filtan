<?php

    namespace Patienceman\Filtan\Console;

    use Illuminate\Console\Command;

    class InstallFiltan extends Command {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'filtan:create {name}';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Create your cutom Query Filters';

        /**
         * The directory where the filter will be created.
         *
         * @var string
         */
        protected $directory = "";

        /**
         * Create a new command instance.
         *
         * @return void
         */
        public function __construct() {
            parent::__construct();
            $this->directory = config('query_filtan.directory');
        }

        /**
         * Execute the console command.
         *
         * @return int
         */
        public function handle() {
            $name = $this->argument('name');

            $pathInfo = pathinfo($name);
            $directory = $this->getDirectory($pathInfo['dirname']);
            $filename = $this->getFilename($directory, $pathInfo['basename']);

            $this->createDirectory($directory);

            $namespace = $this->getNamespace($directory);

            $baseName = basename($filename, ".php");

            $this->writeFile($filename, $this->getFileInitialContents($namespace, $baseName));

            $this->info($filename . " Created successfully");
        }

        /**
         * Get the directory path.
         *
         * @param string $this->directory
         * @param string $dirname
         * @return string
         */
        protected function getDirectory($dirname) {
            return empty($dirname) || $dirname == '.' ? $this->directory : $this->directory . $dirname;
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
        protected function getNamespace($directory) {
            $relativePath = trim(str_replace('app', 'App', $directory), '/');
            $namespace = str_replace('/', '\\', $relativePath);
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
         * Search specific values from industry by name
         *
         * @param string \$query
         */
        public function query(string \$query) {
            \$this->builder->where('name', 'LIKE', '%' . \$query . '%');
        }
    }
    ";
        }
    }
