<?php
    namespace Patienceman\Filtan\Facades;

    use Illuminate\Support\Facades\Facade;

    class Filtan extends Facade {
        protected static function getFacadeAccessor(){
            return 'Filtan';
        }
    }
