<?php

    namespace Patienceman\Filtan;

    use Illuminate\Support\ServiceProvider;
    use Patienceman\Filtan\Console\InstallFiltan;
    use Patienceman\Filtan\Console\PublishFiltanConfig;     

    class FiltanServiceProvider extends ServiceProvider {
        /**
         * Register services.
         *
         * @return void
         */
        public function register() {
            $this->mergeConfigFrom(__DIR__.'/config/query_filtan.php', 'query_filtan');
        }

        /**
         * Bootstrap services.
         *
         * @return void
         */
        public function boot() {
            if ($this->app->runningInConsole()) {
                $this->commands([
                    InstallFiltan::class,
                    PublishFiltanConfig::class,
                ]);
    
                $this->publishes([
                    __DIR__.'/config/query_filtan.php' => config_path('query_filtan.php'),
                ], 'config');
            }
        }
    }
