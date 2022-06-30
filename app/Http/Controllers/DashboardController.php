<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $laporans = Laporan::all();

        $i_bulan = Carbon::now()->translatedFormat('F');
        $bulan = Carbon::now()->format('m');
        $hari = Carbon::now()->format('d');
        $local = Carbon::now()->format('l');
        // dd($bulan);

        $customer_counts = Laporan::count();
        $customer_M_counts = Laporan::whereMonth('date', $bulan)->count();
        $customer_d_counts = Laporan::whereMonth('date', $bulan)->whereDay('date', $hari)->count();
        $reports = Laporan::join('customers', 'laporans.id_customer', '=', 'customers.id')
        ->join('users', 'laporans.created_by', '=', 'users.id')
        ->select('laporans.id', 'laporans.date', 'laporans.deal', 'laporans.customer_information', 'customers.no_wa', 'customers.name', 'laporans.qty', 'laporans.order', 'laporans.description', 'users.name as uname')
        ->whereMonth('laporans.date', $bulan)
        ->get();
        // $charts = DB::table('laporans')->join('users', 'laporans.created_by', '=', 'users.id')
        // ->select('users.name as uname')
        // ->groupBy('uname')
        // ->get();
        $s_bulan = DB::table('laporans')->selectRaw(' monthname(date) as month , month(date) as nomonth, year(date) as year')
        ->groupBy('year', 'month', 'nomonth')
        ->orderBy('year')
        ->orderBy('nomonth')
        ->pluck('month');
        $chart_vira = DB::table('laporans')->join('users', 'laporans.created_by', '=', 'users.id')
        ->select('users.name as uname')
        ->where('laporans.created_by', '=', 3)
        ->groupBy('uname')
        ->pluck('uname');
        $chart_luluk = DB::table('laporans')->join('users', 'laporans.created_by', '=', 'users.id')
        ->select('users.name as uname')
        ->where('laporans.created_by', '=', 4)
        ->groupBy('uname')
        ->pluck('uname');
        $chart_t_customer_vira = DB::table('laporans')->select('created_by', DB::RAW('COUNT(id) as count'))->groupBy('created_by')->where('created_by', '=', 3)->pluck('count');
        $chart_t_customer_luluk = DB::table('laporans')->select('created_by', DB::RAW('COUNT(id) as count'))->groupBy('created_by')->where('created_by', '=', 4)->pluck('count');
        $chart_tb_customer_vira = DB::table('laporans')->select('created_by', DB::RAW('COUNT(id) as count'))->groupBy('created_by')->where('created_by', '=', 3)->whereMonth('date', $bulan)->pluck('count');
        $chart_tb_customer_luluk = DB::table('laporans')->select('created_by', DB::RAW('COUNT(id) as count'))->groupBy('created_by')->where('created_by', '=', 4)->whereMonth('date', $bulan)->pluck('count');
        $chart_p_bulan_vira = DB::table('laporans')->select(DB::RAW('COUNT(id) as id'))->selectRaw(' monthname(date) as month , month(date) as nomonth, year(date) as year')
        ->groupBy('year', 'month', 'nomonth')
        ->orderBy('year')
        ->orderBy('nomonth')
        ->where('created_by', '=', 3)
        ->pluck('id');
        $chart_p_bulan_luluk = DB::table('laporans')->select(DB::RAW('COUNT(id) as id'))->selectRaw(' monthname(date) as month , month(date) as nomonth, year(date) as year')
        ->groupBy('year', 'month', 'nomonth')
        ->orderBy('year')
        ->orderBy('nomonth')
        ->where('created_by', '=', 4)
        ->pluck('id');
        // dd($chart_p_bulan_vira);

        return view('dashboard.index', compact('customer_counts',
        'customer_M_counts',
        'customer_d_counts',
        'i_bulan',
        'hari',
        'reports',
        's_bulan',
        'chart_vira',
        'chart_luluk',
        'chart_t_customer_vira',
        'chart_t_customer_luluk',
        'chart_tb_customer_vira',
        'chart_tb_customer_luluk',
        'chart_p_bulan_vira',
        'chart_p_bulan_luluk',
    ));
    }
}
