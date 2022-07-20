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
            $this->app->make('Patienceman\Filtan\Filters\QueryFilter');
            $this->app->make('Patienceman\Filtan\Filters\Filterable');
        }

        /**
         * Bootstrap services.
         *
         * @return void
         */
        public function boot() {

        }
    }
