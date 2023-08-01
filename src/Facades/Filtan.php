<?php
    namespace Patienceman\Filtan\Facades;

    use Illuminate\Support\Facades\Facade;

    class Filtan extends Facade {
        /**
         * Get the registered name of the component.
         *
         * @return string
         */
        protected static function getFacadeAccessor(){
            return 'Filtan';
        }
    }
