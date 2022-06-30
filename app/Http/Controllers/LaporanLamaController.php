<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class LaporanLamaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Laporan::join('customers', 'laporans.id_customer', '=', 'customers.id')
                ->select('laporans.*', 'customers.name as customer_name')
                ->latest()
                ->get();
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

        $customers = Customer::get();

        return view('laporan.index', compact('customers'));
    }

    public function store(Request $request)
    {
        if ($request->Item_id == '') {
            $validator = Validator::make($request->all(), [
                'date' => 'required',
                'customer_information' => 'required',
                'qty' => 'required',
                'order' => 'required',
                'description' => 'required',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'Item_id' => 'required',
                'date' => 'required',
                'customer_information' => 'required',
                'qty' => 'required',
                'order' => 'required',
                'description' => 'required',
            ]);
        }

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()], 200);
        }

        Laporan::updateOrCreate(
            ['id' => $request->Item_id],
            [
                'date' => $request->date,
                'deal' => $request->deal,
                'customer_information' => $request->customer_information,
                // 'no_wa' => 12,
                'id_customer' => $request->id_customer,
                'qty' => $request->qty,
                'order' => $request->order,
                'description' => $request->description,
                'created_by' => $request->created_by,
            ]
        );

        return response()->json(['success' => 'Item deleted successfully.']);
    }
}
