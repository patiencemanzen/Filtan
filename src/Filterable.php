<?php
    namespace Patienceman\filtan;

    use Illuminate\Database\Eloquent\Builder;

    trait Filterable {
        /**
         * Get the parsed builder and pass it to QueryFilter for continues
         * Binding and chaining.
         *
         * @param Builder $builder
         * @param QueryFilter $filter
         */
        public function scopeFilter(Builder $builder, QueryFilter $filter) {
            $filter->apply($builder);
        }
    }
