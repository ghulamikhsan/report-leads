<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MasterController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Laporan::latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem">Edit</a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteItem">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $counts_lama = DB::table('laporans')
            ->join('users', 'laporans.created_by', '=', 'users.id')
            ->select('date', DB::raw('COUNT(customer_information) as status'))
            ->where('customer_information', '=', 'lama')
            ->where('users.id', auth()->user()->id)
            ->groupBy('date')
            ->get();
        // dd($counts_lama);
        $counts_baru = DB::table('laporans')
            ->join('users', 'laporans.created_by', '=', 'users.id')
            ->select('date', DB::raw('COUNT(customer_information) as status'))
            ->where('customer_information', '=', 'baru')
            ->where('users.id', auth()->user()->id)
            ->groupBy('date')
            ->get();
        $detail = Laporan::all();

        // dd($counts_baru);

        // if ($counts_baru->isEmpty()){

        // dd('kosong');
        // }
        // dd($counts_baru->status);

        return view('master.index', compact('counts_lama', 'counts_baru', 'detail'));
    }
}
