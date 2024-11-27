<?php

    return [
        /**
         * -----------------------------------
         * Default Query Filters Directory 
         * ------------------------------------
         * 
         * This is the base directory where your query filters will be stored.
         * By default, it is set to 'Http', which means the filters will be
         * placed under the 'app/Http' directory.
         */
        'filtan_folder' => 'Http',

        /**
         * ----------------------------------
         * Default Query Filters Folder Name
         * ----------------------------------
         * 
         * This is the name of the folder that will contain all the query filters.
         * By default, it is set to 'QueryFilters'. If you change this name,
         * make sure to update the namespacing accordingly.
         */
        'filters_folder_name' => 'QueryFilters',
    ];