<?php

namespace App\Http\Controllers;

use App\Models\Ratio;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RatioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Ratio::get();
            // dd($data);
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem"><i class="fas fa-edit"></i></a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-url="'.route('laporan.destroy', $row->id).'" data-original-title="Delete" class="btn btn-danger btn-sm deleteItem"><i class="fas fa-trash"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('ratio.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            Ratio::updateOrCreate(
                ['id' => $request->Ratio_id],
                [
                    'name' => $request->name,
                    'date' => $request->date,
                    'turnover' => $request->turnover,
                    'profit' => $request->profit,
                    'adv_budget' => $request->adv_budget,
                ]
            );

            return Response()->json(['success' => 'Ratio Berhasil Disimpan']);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ratio = Ratio::find($id);

        return Response()->json($ratio);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Ratio::find($id)->delete();

        return Response()->json(['success' => 'Rasio Berhasil Dihapus']);
    }
}
