<?php

    namespace Patienceman\Filtan;

    use Illuminate\Support\ServiceProvider;
    use Patienceman\Filtan\Console\CreateFiltersCommand;
    use Patienceman\Filtan\Console\PublishFiltanConfig;     

    class FiltanServiceProvider extends ServiceProvider {
        /**
         * Register services.
         *
         * @return void
         */
        public function register() {
            $this->mergeConfigFrom(__DIR__.'/config/filtan.php', 'filtan');
        }

        /**
         * Bootstrap services.
         *
         * @return void
         */
        public function boot() {
            if ($this->app->runningInConsole()) {
                $this->commands([
                    CreateFiltersCommand::class,
                    PublishFiltanConfig::class,
                ]);
    
                $this->publishes([
                    __DIR__.'/config/filtan.php' => config_path('filtan.php'),
                ], 'config');
            }
        }
    }
