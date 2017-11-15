<?php

namespace App\Http\Controllers;

use App\Order;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function getLastSevenDaysOfOrders($pid = null){

        $prevDays = date('Y-m-d', strtotime('-7 days'));
        $currentDay= date('Y-m-d');

        if($pid == null ){
            $orders = DB::table('orders')
                ->select(
                    DB::raw("date(created_at) as date"),
                    DB::raw("COUNT(*) as count"))
                ->whereBetween("created_at", [$prevDays ,$currentDay])
                ->groupBy(DB::raw("date(created_at)"))
                ->get();
        }else {
            $orders = DB::table('orders')
                ->select(
                    DB::raw("date(created_at) as date"),
                    DB::raw("COUNT(*) as count"))
                ->whereBetween("created_at", [$prevDays ,$currentDay])
                ->where("partner_id", $pid)
                ->groupBy(DB::raw("date(created_at)"))
                ->get();
        }


        $result[] = ['Day','Count'];
        foreach ($orders as $key => $value) {
            $result[++$key] = [$value->date, (int)$value->count];
        }

       return json_encode($result);



    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->isAdmin()){
            $data = $this->getLastSevenDaysOfOrders();
        }else {
            $data = $this->getLastSevenDaysOfOrders(Auth::user()->partner_id);

        }

        return view('home')->with('data',$data);
    }






}
