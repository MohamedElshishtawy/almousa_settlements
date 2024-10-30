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
        return Office::where('start_date', '<=', now()->toDate())->where('end_date', '>=', now() )->get();
    }

}
