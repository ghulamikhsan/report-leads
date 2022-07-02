<?php

namespace App\Http\Controllers;

use App\Exports\LaporanBulananExport;
use App\Exports\LaporanTahunanExport;
use App\Models\bulan;
use App\Models\Customer;
use App\Models\Laporan;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Html\Column;

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
        // $months = Laporan::get()->groupBy('date');;
        $bulan = bulan::get()->groupBy('month', 'year');
        $hitung = count($bulan);
        for ($i = 1; $i <= 12; ++$i) {
            $dateb[$i] = bulan::select('month', 'year')->whereMonth('date', $i)->get()->first();
        }
        // dd($dateb);
        return view('detail.indexbln', compact('months', 'bulan', 'dateb'));
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
        // dd($counts_baru);
        return view('detail.showuser', compact('report', 'counts_lama', 'counts_baru', 'laporans', 'tgl'));
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
        // dd($months);
        return view('detail.showtgl', compact('months'));
    }

    public function showbln($date)
    {
        $months = bulan::join('customers', 'bulan.id_customer', '=', 'customers.id')
            ->join('users', 'bulan.created_by', '=', 'users.id')
            ->select('bulan.*', 'customers.name as customer_name', 'customers.no_wa as number')
            ->where('users.id', '=', auth()->user()->id)
            ->where('month', $date)
            ->get();
        $bln = bulan::select('nomonth')->where('month', $date)->get()->first();
        $bln2 = bulan::select('month')->where('month', $date)->get()->first();
        // dd($bln);
        return view('detail.showbln', compact('months', 'bln', 'bln2'));
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
        $bulan = Carbon::now()->format('m');

        return Excel::download(new LaporanBulananExport($tahun, $date), 'Lead_bulanan.xlsx');
    }

    public function export_excel_tahunan($date)
    {
        $tahun = Carbon::now()->format('Y');
        $bulan = Carbon::now()->format('m');

        return Excel::download(new LaporanTahunanExport($tahun, $date), 'Lead_tahunan.xlsx');
    }

    public function html()
    {
        return $this->builder()
                    ->setTableId('bulan-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->parameters([
                        'dom' => 'Bfrtip',
                        'buttons' => ['excel', 'csv'],
                    ]);
    }

    protected function getColumns()
    {
        return [
            Column::make('date'),
            Column::make('customer_information'),
            Column::make('no_wa'),
            Column::make('id_customer'),
            Column::make('qty'),
            Column::make('order'),
            Column::make('description'),
        ];
    }

    protected function filename()
    {
        return 'Laporan-Bulan_'.date('Ym');
    }
}
