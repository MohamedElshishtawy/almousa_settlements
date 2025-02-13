<?php

namespace App\Report;

use Carbon\Carbon;

class ReportSurvice
{

    /**
     * Get days
     *
     * @param $offices
     * @param $reports  // inter the reports for the user (user can be admin or employee)
     * @return \Illuminate\Support\Collection
     *
     * This function will provide you with all days between the start and end date of the office.
     * it helps to get the report of each day, whoever the report created or not.
     */


    public function getDays($offices)
    {
        $days = collect();
        foreach ($offices as $office) {
            foreach ($office->OfficeMissions as $officeMission) {
                // main mission
                $currentDate = Carbon::parse($officeMission->start_date);
                $endDate = Carbon::parse($officeMission->end_date);
                while ($currentDate <= $endDate) {
                    $report = Report::where('office_id', $office->id)->where('for_date',
                        $currentDate->toDateString())->first();
                    $data = [
                        'office' => $office,
                        'officeMission' => $officeMission,
                        'import' => $report ? $report->import : [],
                        'surplus' => $report && $report->surplus && $report->surplus->count() > 0 ? $report->surplus : [],
                        'date' => $currentDate->toDateString(),
                    ];

                    $days->push($data);
                    $currentDate = $currentDate->addDay();
                }
            }

        }
        // sort days with date
        $days = $days->sortBy('date');
        return $days;
    }

    public function getDaysForOffice($office)
    {
        $days = collect();

        foreach ($office->OfficeMissions as $officeMission) {
            // main mission
            $currentDate = Carbon::parse($officeMission->start_date);
            $endDate = Carbon::parse($officeMission->end_date);
            while ($currentDate <= $endDate) {
                $days->push($currentDate->toDateString());
                $currentDate = $currentDate->addDay();
            }
        }

        // sort days with date


        return $days;
    }

    public function getDaysForOffices($officesCollection)
    {
        $days = collect();
        foreach ($officesCollection as $office) {
            $days = $days->merge($this->getDaysForOffice($office));
        }
        return $days->unique();
    }


    public function days2groupOffices($days)
    {
        /*
         * This fuction used to group the array of days to offices groups
         * it makes the array easer to be read to the front end for users multeble offices*/
        $officeReports = [];

        // Group by office name
        foreach ($days as $day) {
            $officeReports[$day['office']->name][] = $day;
        }
        return $officeReports;

    }


}
