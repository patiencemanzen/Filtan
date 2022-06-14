<?php
    namespace Patienceman\filtan;

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
         * Apply builder and call each associated query string function
         */
        public function apply($builder) {
            $this->builder = $builder;

            /**
             * Loop over all query strings and call associated function
             * from the class that extended this
             */
            foreach ($this->fields() as $field => $value) {
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
