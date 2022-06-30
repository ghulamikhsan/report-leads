<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Customer::join('users', 'customers.created_by', '=', 'users.id')
                ->select('customers.*', 'users.name as user_name')
                ->where('users.id', '=', auth()->user()->id)
                ->latest()
                ->get();
            // dd($data);
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem"><i class="fas fa-edit"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-url="' . route('laporan.destroy', $row->id) . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteItem"><i class="fas fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('customers.index');
    }

    public function store(Request $request)
    {
        try {
            Customer::updateOrCreate(
                ['id' => $request->Customer_id],
                [
                    'name' => $request->name,
                    'no_wa' => $request->no_wa,
                    'orign' => $request->orign,
                ]
            );
            return Response()->json(['success' => 'Customer saved successfully.']);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function edit($id)
    {
        $customer = Customer::find($id);
        return Response()->json($customer);
    }

    public function destroy($id)
    {
        Customer::find($id)->delete();
        return Response()->json(['success' => 'Laporan Berhasil dihapus']);
    }
}
