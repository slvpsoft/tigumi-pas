<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalendarTest extends Controller
{
    public function showCalendar(Request $request) {
        $month = date('m');
        $year = date('Y');

        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $firstDay = date('N', strtotime("$year-$month-01"));
        $firstDay = $firstDay == 7 ? 1 : $firstDay + 1;

        return view('pages.home', [
            'month' => $month,
            'year' => $year,
            'daysInMonth' => $daysInMonth,
            'firstDay' => $firstDay,
        ]);
    }
}
