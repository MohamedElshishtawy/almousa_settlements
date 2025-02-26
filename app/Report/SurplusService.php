<?php

namespace App\Report;

class SurplusService
{
    protected Surplus $surplus;

    public function __construct(Surplus $surplus)
    {
        $this->surplus = $surplus;
    }


}
