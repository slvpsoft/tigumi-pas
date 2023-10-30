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
        ->where(function($query) use ($request_label){
            $query->where('label', $request_label)
            ->orWhere('label', 'like', '%'. $request_label .'%');
        })->get()->first();
        if(!$expLabel){
            // Create new Label
            $newLabel = new ExpenseLabel;
            $newLabel->label = $request_label;
            $newLabel->user_id = $user->id;
            $newLabelID = $newLabel->save();
        }

        // Check if Category Exists
        $request_category = preg_replace("/[^A-Za-z0-9 ]/", '', $request->category);
        $expCategory = ExpenseCategory::where('user_id', $user->id)
        ->where(function($query) use ($request_category){
            $query->where('Category', $request_category)
            ->orWhere('Category', 'like', '%'. $request_category .'%');
        })->get()->first();
        if(!$expCategory){
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

        return redirect('dashboard');
    }
}
