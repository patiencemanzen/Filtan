<?php

    namespace Patienceman\filtan;

    use Illuminate\Support\ServiceProvider;

    class FiltanServiceProvider extends ServiceProvider {
        /**
         * Register services.
         *
         * @return void
         */
        public function register() {
            $this->app->make('Patienceman\filtan\QueryFilter');
            $this->app->make('Patienceman\filtan\Filterable');
        }

        /**
         * Bootstrap services.
         *
         * @return void
         */
        public function boot() {
            //
        }
    }
