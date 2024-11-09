<?php

namespace App\Office\OfficeQuery;

use App\Office\Office;

class InTimeRange
{

    public function __construct()
    {

    }

    public function run()
    {
        return Office::where(function ($query) {
            $query->where('getting_ready_start_date', '<=', now()->toDate())
                ->orWhere('start_date', '>=', now()->toDate());
        })->where(function ($query) {
            $query->where('getting_ready_end_date', '>=', now()->toDate())
                ->orWhere('end_date', '<=', now()->toDate());
        })->get();
    }

}
