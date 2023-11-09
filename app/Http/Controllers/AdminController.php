<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ExpenseLabel;
use App\Models\ExpenseLog;

class AdminController extends Controller
{
    // Home
    public function dashboard(Request $request)
    {
        // Calendar Helper
        $month = date('m');
        $year = date('Y');
        $monthName = date('F');

        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $firstDay = date('N', strtotime("$year-$month-01"));
        $firstDay = $firstDay == 7 ? 1 : $firstDay + 1;

        // Exp Management
        $startDate = "$year-$month-01";
        $endDate = "$year-$month-" . $daysInMonth;
        // $totalMonthExp = 9999;
        // $expList = [
        //     2 => 250
        // ];
        // $combo = 99;

        $expList = [];
        // Get all user expenses of the month
        $expLogs = ExpenseLog::where('user_id', auth()->id())
            ->whereBetween('log_date', [$startDate, $endDate])->get();

        // Calculate total expenses amount
        $totalMonthExp = $expLogs->pluck('amount')->sum();

        // Get total expenses by day
        $expLogDates = $expLogs->groupBy('log_date')->map(function ($logList) {
            return $logList->reduce(function ($sum, $log) {
                return $sum + $log->amount;
            });
        })->all();

        // Reformat keys of dates to days
        foreach ($expLogDates as $key => $expLog) {
            $newKey = (int) str_replace("$year-$month-", '', $key);
            $expList[$newKey] = $expLog;
        }

        // Combo Prep
        $expCombo = 0;
        $logDateValues = ExpenseLog::where('user_id', auth()->id())
            ->where('log_date', '<=', date('Y-m-d'))->pluck('log_date')->sortKeysDesc()->unique();
        $firstLog = $logDateValues->first();
        $logDates = $logDateValues->all();
        $sampleCompare = [];
        $lastDate = "";
        // Calculate for Streak Combo

        foreach ($logDates as $key => $logDate) {
            $dateNow = $logDate == $firstLog ? date('Y-m-d') : $lastDate;
            // Checks if the combo was more than 2 days gap
            if (((int) date_diff(date_create($dateNow),date_create($logDate))->format('%a')) >= 2) {

                // Combo Broken
                break;
            } else {
                if ($expCombo == 0) {
                    // There is always a first!
                    $expCombo = $logDate == $firstLog ? 1 : 0;
                }else{

                    // Nice Combo!
                    $expCombo++;
                }
            }

            $lastDate = $logDate;
        }

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
            'combo' => $expCombo,
            'expList' => $expList,
            'expKeys' => $expKeys
        ]);
    }

    // Expense
    function addExpense()
    {
        return view('pages.add');
    }

    function storeExpense(Request $request)
    {
        $request->validate([
            'label' => ['required'],
            'category' => ['required'],
            'amount' => ['required'],
        ]);

        $newLabelID = '';
        $newCategoryID = '';
        $user = auth()->user();

        // Check if Label Exists
        $request_label = preg_replace("/[^A-Za-z0-9 ]/", '', $request->label);
        $expLabel = ExpenseLabel::where('user_id', $user->id)
            ->where(function ($query) use ($request_label) {
                $query->where('label', $request_label)
                    ->orWhere('label', 'like', '%' . $request_label . '%');
            })->get()->first();
        if (!$expLabel) {
            // Create new Label
            $newLabel = new ExpenseLabel;
            $newLabel->label = $request_label;
            $newLabel->user_id = $user->id;
            $newLabelID = $newLabel->save();
        }

        // Check if Category Exists
        $request_category = preg_replace("/[^A-Za-z0-9 ]/", '', $request->category);
        $expCategory = ExpenseCategory::where('user_id', $user->id)
            ->where(function ($query) use ($request_category) {
                $query->where('Category', $request_category)
                    ->orWhere('Category', 'like', '%' . $request_category . '%');
            })->get()->first();
        if (!$expCategory) {
            // Create new Category
            $newCategory = new ExpenseCategory;
            $newCategory->category = $request_category;
            $newCategory->user_id = $user->id;
            $newCategoryID = $newCategory->save();
        }

        // Add Expense
        $expLog = new ExpenseLog;
        $expLog->user_id = $user->id;
        $expLog->label_id = $newLabelID != '' ? $newLabelID : $expLabel['id'];
        $expLog->category_id = $newCategoryID != '' ? $newCategoryID : $expCategory['id'];
        $expLog->amount = $request->amount;
        $expLog->log_date = Carbon::now();
        $expLog->save();

        // Clear Hashed Cache

        return redirect('dashboard');
    }
}
