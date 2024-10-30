<?php

namespace App\Report;

use mysql_xdevapi\Collection;
use Carbon\Carbon;
class ReportSurvice
{

    /**
     * Get days
     *
     * @param $offices
     * @param $reports // inter the reports for the user (user can be admin or employee)
     * @return \Illuminate\Support\Collection
     *
     * This function will provide you with all days between the start and end date of the office.
     * it helps to get the report of each day, whoever the report created or not.
     */


    public function getDays($offices)
{
    $days = collect();
    foreach ($offices as $office) {
        $currentDate = Carbon::parse($office->start_date);
        $endDate = Carbon::parse($office->end_date);

        while ($currentDate <= $endDate) {
            $report = Report::where('office_id', $office->id)->where('for_date', $currentDate->toDateString())->first();

            $data = [
                'office' => $office,
                'import' => $report ? $report->import : [],
                'surplus' => $report ? $report->surplus : [],
                'date' => $currentDate->toDateString(),
            ];

            $days->push($data);
            $currentDate = $currentDate->addDay();
        }
    }
    return $days;
}

}
