<?php

    namespace Patienceman\Filtan;

    use Illuminate\Support\ServiceProvider;
    use Patienceman\Filtan\Console\InstallFiltan;

    class FiltanServiceProvider extends ServiceProvider {
        /**
         * Register services.
         *
         * @return void
         */
        public function register() {

        }

        /**
         * Bootstrap services.
         *
         * @return void
         */
        public function boot() {
            if ($this->app->runningInConsole()) {
                $this->commands([
                    InstallFiltan::class
                ]);
            }
        }
    }
