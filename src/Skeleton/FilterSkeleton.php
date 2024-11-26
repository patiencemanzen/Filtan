<?php
    namespace App\Http\QueryFilters;

    use Patienceman\Filtan\QueryFilter;

    class FilterSkeleton extends QueryFilter {
        /**
         * Search specific values from industry by name
         *
         * @param string $query
         */
        public function query(string $query) {
            $this->builder->where('name', 'LIKE', '%' . $query . '%');
        }
    }