<?php

    namespace Patienceman\Filtan\Console;

    use Illuminate\Console\Command;

    class PublishFiltanConfig extends Command {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'filtan:config';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Publish the Filtan configuration file';

        /**
         * Execute the console command.
         *
         * @return void
         */
        public function handle() {
            $this->call('vendor:publish', [ '--tag' => 'config', '--force' => true ]);
            $this->info('Filtan configuration file published successfully.');
        }
    }