<?php

namespace App\Exports;

use App\Models\Laporan;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class BulanExport implements FromView
{
    public function view(): View
    {
        return view('detail.indextgl', [
            'months' => Laporan::with('laporan')->get(),
            'counts_lama' => DB::table('laporans')
            ->join('users', 'laporans.created_by', '=', 'users.id')
            ->select('date', DB::raw('COUNT(customer_information) as status'))
            ->where('customer_information', '=', 'lama')
            ->where('users.id', auth()->user()->id)
            ->groupBy('date')
            ->get(),
            'counts_baru' => DB::table('laporans')
            ->join('users', 'laporans.created_by', '=', 'users.id')
            ->select('date', DB::raw('COUNT(customer_information) as status'))
            ->where('customer_information', '=', 'baru')
            ->where('users.id', auth()->user()->id)
            ->groupBy('date')
            ->get(),
        ]);
    }
}
