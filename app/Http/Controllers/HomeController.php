<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Util; 
use App\Models\BillingUser;
use App\Models\Payment;

class HomeController extends Controller
{
    use Util; 
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $filter = $this->getFilterYearandMonth(); 

        $filter['year'] = request('year')?: $filter['year'];
        $filter['month'] = request('month')?: $filter['month'];

        $permonth = BillingUser::where([
            'year' => $filter['year'],
            'month' => $filter['month'],
            'user_id' => auth()->user()->id,
        ])->orderBy('billing_name')->get(); 

        $permonth = $permonth->filter(function($value) {
            return ($value->status == 'B') || ($value->status == 'L');
        })->map(function($value) {
            $value->status = $value->status == 'L' ? 'Lunas' : $value->status; 
            $value->status = $value->status == 'B' ? 'Belum Lunas' : $value->status;
            return $value;
        });


        $monthName = $this->getMonthName($filter['month']); 

        $belumLunas =  number_format($permonth->filter(function($value){
            return $value->status == 'Belum Lunas';
        })->sum('amount'),2); 

        $lunas = number_format($permonth->filter(function($value){
            return $value->status == 'Lunas';
        })->sum('amount'),2);

        return view('home', [
            'filter' => $filter, 
            'monthName' => $monthName,
            'perMonth' => $permonth,
            'lunas' => $lunas,
            'belumLunas' => $belumLunas,
            'payments' => Payment::all(),
        ]);

    }

    public function getOtherBill()
    {
        $otherBill = BillingUser::where([
            'user_id' => auth()->user()->id,
            'status' => 'B'
        ])->get();

        $otherBill = $otherBill->filter(function($value) {
            return $value->year == request('year') && $value->month == request('month') ? false : true;
        })->map(function($value) {
            $value->monthName =  $this->getMonthName($value->month);
            
            return $value;
        });

        $total = number_format($otherBill->sum('amount'), 2);

        return view('otherbill', [
            'data' => $otherBill,
            'total' => $total,
        ]);

    }
}
