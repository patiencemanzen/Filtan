<?php
    namespace Patienceman\Filtan;

    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Http\Request;
    use Illuminate\Support\Str;

    abstract class QueryFilter {
        /**
         *  Fetch the incoming request
         *
         * @var Request
         */
        protected $request;

        /**
         * The incoming Query Builder will be stored here
         *
         * @var Builder
         */
        protected $builder;

        /**
         * Initialize Http request
         *
         * @param Request $request
         */
        public function __construct(Request $request) {
            $this->request = $request;
        }

        /**
         * map focuses to the main target
         *
         * @param array $target
         * @param array $focus
         * @return array
         */
        public function findFocuses($target, $focus) {
            $focused = [];
            foreach($focus as $f)
                $focused[$f] = $target[$f];
            return $focused;
        }

        /**
         * Apply builder and call each associated query string function
         */
        public function apply($builder, array $focus) {
            $this->builder = $builder;

            if($focus && $this->fields())
                foreach ($this->findFocuses($this->fields(), $focus) as $field => $value)
                    $this->caller($field, $value);

            /**
             * Loop over all query strings and call associated function
             * from the class that extended this
             */
            if(!$focus)
                foreach ($this->fields() as $field => $value)
                    $this->caller($field, $value);
        }

        /**
         * Call customer user function
         *
         * @param string $field
         * @param string $value
         * @return void
         */
        public function caller($field, $value) {
            $method = Str::camel($field);

            /**
             * Check is formed method already
             * exist in this class
             */
            if (method_exists($this, $method)) {

                // then call method from this class and pass the values
                call_user_func_array([$this, $method], (array)strtolower($value));
            }
        }

        /**
         * Returns an array containing all the query strings
         *
         * @return array
         */
        protected function fields(): array {
            return array_filter(
                array_map('trim', $this->request->all())
            );
        }
    }
