<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Home
    public function dashboard(Request $request) {
        // Calendar Helper
        $month = date('m');
        $year = date('Y');
        $monthName = date('F');

        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $firstDay = date('N', strtotime("$year-$month-01"));
        $firstDay = $firstDay == 7 ? 1 : $firstDay + 1;

        // Exp Management
        // Get DB Data
        $totalMonthExp = 9999;
        $combo = 99;
        $expList = [
            2 => 250
        ];
        $expKeys = array_keys($expList);

        // TODO: Cache Dis
        // TODO: Remember to Hash

        return view('pages.home', [
            // Calendar Variables
            'month' => $month,
            'year' => $year,
            'daysInMonth' => $daysInMonth,
            'firstDay' => $firstDay,
            'monthName' => $monthName,
            // Expense Variables
            'totalMonthExp' => $totalMonthExp,
            'combo' => $combo,
            'expList' => $expList,
            'expKeys' => $expKeys
        ]);
    }

    // Expense
    function addExpense() {
        return view('pages.add');
    }

    function storeExpense(Request $request){
        // Add Expense
        // dd($request->all());

        return redirect('dashboard');
    }
}
