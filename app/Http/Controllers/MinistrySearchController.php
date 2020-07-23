<?php

namespace App\Http\Controllers;

use App\Ministry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MinistrySearchController extends Controller
{
    public function filterExpenses(Request $request)
    {
        $id = $request->query('id');
        echo "php-id {$id} <br />";
        $givenTime = null;
        if ($request->has('date')) {
            $givenTime = $request->query('date');
        }

        echo 'fullurl: '. $request->fullUrl();
        echo "<br />";
        var_dump($request->all());
        echo "<br />";
        echo 'query_id: '. $request->query('id');
        echo "<br />";
        echo 'query_date: '. $request->query('date');
        echo "<br />";
        echo 'input: '. $request->input('id');
        echo "<br />";
        
        
        $yr = date("Y");
        $ministry = Ministry::find($id);
        echo $ministry;
        $code = $ministry->code;
        $day_pattern = '/(\d{4})-(\d{2})-(\d{2})/';
        $mth_pattern = '/([A-Za-z]+)\s(\d{4})/';
        $yr_pattern = '/\d{4}/';

        if (preg_match($mth_pattern, $givenTime, $match)) {
            $m = date_parse($match[1]);
            $month = $m['month'];
            $year = $match[2];
            $payments = DB::table('payments')
                    ->where('payment_code', 'LIKE', "$code%")
                    ->whereMonth('payment_date', '=', $month)
                    ->whereYear('payment_date', '=', $year);
        } elseif (preg_match($day_pattern, $givenTime, $match)) {
            $payments = DB::table('payments')
                    ->where('payment_code', 'LIKE', "$code%")
                    ->where('payment_date', '=', "$givenTime");
        } elseif (preg_match($yr_pattern, $givenTime, $match)) {
            $payments = DB::table('payments')
                    ->where('payment_code', 'LIKE', "$code%")
                    ->whereYear('payment_date', '=', "$givenTime");
        } else {
            $payments = DB::table('payments')
                    ->where('payment_code', 'LIKE', "$code%")
                    ->whereYear('payment_date', '>=', "$yr");
        };

        if ($request->has('sort')) {
            $payments = $payments->orderby('amount', $request->query('sort'));
        } else {
            $payments = $payments->orderby('payment_date', 'desc');
        }
        
        $payments = $payments->paginate(2);
       
        return view('pages.ministry.pagination')
        ->with(['ministry'=> $ministry,
                'payments' => $payments,
             ]);
    }
}
