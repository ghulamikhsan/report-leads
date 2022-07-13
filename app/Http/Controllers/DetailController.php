<?php

namespace App\Http\Controllers;

use App\Exports\BulanExport;
use App\Exports\LaporanBulananExport;
use App\Exports\LaporanTahunanExport;
use App\Models\bulan;
use App\Models\Customer;
use App\Models\Laporan;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DetailController extends Controller
{
    public function index()
    {
        $names = User::get();

        return view('detail.index', compact('names'));
    }

    public function indextgl()
    {
        $months = Laporan::get()
            ->groupBy('date');

        return view('detail.indextgl', compact('months'));
    }

    public function indexbln()
    {
        $months = DB::table('laporans')->selectRaw(' monthname(date) as month , month(date) as nomonth, year(date) as year')
            ->groupBy('year', 'month', 'nomonth')
            ->orderBy('year')
            ->orderBy('nomonth')
            ->get();
        $bulan = bulan::get()->groupBy('month', 'year');
        // dd($dateb);
        return view('detail.indexbln', compact('months', 'bulan'));
    }

    public function indexthn()
    {
        $bulan = bulan::get()->groupBy('year');
        // dd($bulan);

        return view('detail.indexthn', compact('bulan'));
    }

    public function indexcust()
    {
        $cust = Customer::get();
        // dd($cust);

        return view('detail.indexcust', compact('cust'));
    }

    public function show($created_by)
    {
        $names = User::find($created_by);
        $report = Laporan::find($created_by);
        // $report = DB::table('laporans')->where('created_by', auth()->user()->id)->get();
        $counts_lama = DB::table('laporans')
            ->join('users', 'laporans.created_by', '=', 'users.id')
            ->select('date', DB::raw('COUNT(customer_information) as status'))
            ->where('customer_information', '=', 'lama')
            ->where('users.id', $created_by)
            ->groupBy('date')
            ->get();
        // dd($counts_lama);
        $counts_baru = DB::table('laporans')
            ->join('users', 'laporans.created_by', '=', 'users.id')
            ->select('date', DB::raw('COUNT(customer_information) as status'))
            ->where('customer_information', '=', 'baru')
            ->where('users.id', $created_by)
            ->groupBy('date')
            ->get();
        $laporans = DB::table('laporans')
            ->join('customers', 'laporans.id_customer', '=', 'customers.id')
            ->join('users', 'laporans.created_by', '=', 'users.id')
            ->select('laporans.id', 'laporans.date', 'laporans.deal', 'laporans.customer_information', 'customers.no_wa', 'customers.name', 'laporans.qty', 'laporans.order', 'laporans.description', 'users.name as uname')
            ->where('users.id', $created_by)
            ->get();
        $tgl = Laporan::selectRaw(' monthname(date) as month , month(date) as nomonth, year(date) as year')
                ->groupBy('year', 'month', 'nomonth')
                ->orderBy('year')
                ->orderBy('nomonth')
                ->get();
        // dd($names);

        return view('detail.showuser', compact('report', 'counts_lama', 'counts_baru', 'laporans', 'tgl', 'names'));
    }

    public function showtgl($date)
    {
        $months = DB::table('laporans')
            ->join('customers', 'laporans.id_customer', '=', 'customers.id')
            ->join('users', 'laporans.created_by', '=', 'users.id')
            ->select('laporans.id', 'laporans.date', 'laporans.deal', 'laporans.customer_information', 'laporans.no_wa', 'customers.name', 'laporans.qty', 'laporans.order', 'laporans.description', 'users.name as uname')
            ->get()
            ->where('date', $date)
            ->groupBy('date');
        $tanggal = Laporan::select('date')->where('date', $date)->first();
        // dd($tanggal);

        return view('detail.showtgl', compact('months', 'tanggal'));
    }

    public function showbln($date)
    {
        $months = bulan::join('customers', 'bulan.id_customer', '=', 'customers.id')
            ->join('users', 'bulan.created_by', '=', 'users.id')
            ->select('bulan.*', 'customers.name as customer_name', 'customers.no_wa as number')
            ->where('users.id', '=', auth()->user()->id)
            ->where('month', $date)
            ->get();
        $counts_lama = DB::table('laporans')
            ->join('users', 'laporans.created_by', '=', 'users.id')
            ->select('date', DB::raw('COUNT(customer_information) as status'))
            ->where('customer_information', '=', 'lama')
            ->where('users.id', auth()->user()->id)
            ->groupBy('date')
            ->get();
        $counts_baru = DB::table('laporans')
            ->join('users', 'laporans.created_by', '=', 'users.id')
            ->select('date', DB::raw('COUNT(customer_information) as status'))
            ->where('customer_information', '=', 'baru')
            ->where('users.id', auth()->user()->id)
            ->groupBy('date')
            ->get();
        $bln = bulan::select('nomonth')->where('month', $date)->first();
        $bln2 = bulan::select('month')->where('month', $date)->first();
        // dd($counts_baru);

        return view('detail.showbln', compact('months', 'bln', 'bln2', 'counts_baru', 'counts_lama'));
    }

    public function showthn($date)
    {
        $months = bulan::join('customers', 'bulan.id_customer', '=', 'customers.id')
            ->join('users', 'bulan.created_by', '=', 'users.id')
            ->select('bulan.*', 'customers.name as customer_name', 'customers.no_wa as number')
            ->where('users.id', '=', auth()->user()->id)
            ->where('year', $date)
            ->get();
        $bln = bulan::select('year')->where('year', $date)->get()->first();
        // dd($months);
        return view('detail.showthn', compact('months', 'bln'));
    }

    public function export_excel_bulanan($date)
    {
        $tahun = Carbon::now()->format('Y');
        $nama_file = 'Lead Bulan '.$date.' di download pada '.date('m-d-Y').'.xlsx';

        // return Excel::download(new BulanExport($tahun, $date), $nama_file);
        return Excel::download(new LaporanBulananExport($tahun, $date), $nama_file);
    }

    public function export_excel_tahunan($date)
    {
        $tahun = Carbon::now()->format('Y');
        $nama_file = 'Lead Tahun '.$date.' di download pada '.date('m-d-Y').'.xlsx';

        return Excel::download(new LaporanTahunanExport($tahun, $date), $nama_file);
    }
}
