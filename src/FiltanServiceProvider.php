<?php

    namespace Patienceman\Filtan;

    use Illuminate\Support\ServiceProvider;

    class FiltanServiceProvider extends ServiceProvider {
        /**
         * Register services.
         *
         * @return void
         */
        public function register() {
            $this->app->make('Patienceman\Filtan\QueryFilter');
            $this->app->make('Patienceman\Filtan\Filterable');
        }

        /**
         * Bootstrap services.
         *
         * @return void
         */
        public function boot() {

        }
    }
