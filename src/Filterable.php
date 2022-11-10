<?php
    namespace Patienceman\Filtan;

    use Illuminate\Database\Eloquent\Builder;
    trait Filterable {
        /**
         * Get the parsed builder and pass it to QueryFilter for continues
         * Binding and chaining.
         *
         * @param Builder $builder
         * @param QueryFilter $filter
         */
        public function scopeFilter(Builder $builder, QueryFilter $filter, array $focus = []) {
            $filter->apply($builder, $focus);
        }
    }
