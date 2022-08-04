<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExport;
use App\Models\Customer;
use App\Models\keterangan;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class LaporanController extends Controller
{
    // function __construct()
    // {
    //     $this->middleware('permission:report-view', ['only' => ['index', 'edit']]);
    //     $this->middleware('permission:report-create', ['only' => ['store']]);
    //     $this->middleware('permission:report-delete', ['only' => ['destroy']]);
    // }

    public $month;

    public function index(Request $request)
    {
        $i_bulan = Carbon::now()->translatedFormat('F');

        if (empty($_GET['cari'])) {
            $bulan = Carbon::now()->format('m');
        } else {
            $bulan = $_GET['cari'];
        }

        $tahun = Carbon::now()->format('Y');
        if ($request->ajax()) {
            $data = Laporan::join('customers', 'laporans.id_customer', '=', 'customers.id')
                ->join('users', 'laporans.created_by', '=', 'users.id')
                ->select('laporans.*', 'customers.name as customer_name', 'customers.no_wa as number')
                ->where('users.id', '=', auth()->user()->id)
                ->whereYear('laporans.date', $tahun)
                ->whereMonth('laporans.date', $bulan)
                ->orderBy('laporans.date', 'DESC')
                ->get();

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

        $customers = Customer::where('created_by', auth()->user()->id)->orderBy('name', 'ASC')->get();

        $keterangans = keterangan::select('nama_keterangan')->get();

        $tgl = Laporan::selectRaw(' monthname(date) as month , month(date) as nomonth, year(date) as year')
                ->groupBy('year', 'month', 'nomonth')
                ->orderBy('year')
                ->orderBy('nomonth')
                ->get();

        $data = Laporan::join('customers', 'laporans.id_customer', '=', 'customers.id')
                ->join('users', 'laporans.created_by', '=', 'users.id')
                ->select('laporans.*', 'customers.name as customer_name', 'customers.no_wa as number')
                ->where('users.id', '=', auth()->user()->id)
                ->whereYear('laporans.date', $tahun)
                ->whereMonth('laporans.date', $bulan)
                ->orderBy('laporans.date')
                ->get();

        $months = Laporan::select('date')->groupBy('date')->get();

        // dd($data);

        return view('laporan.index', compact('customers', 'tgl', 'keterangans', 'i_bulan'));
    }

    public function store(Request $request)
    {
        if ($request->Item_id == '') {
            $validator = Validator::make($request->all(), [
                'date' => 'required',
                'customer_information' => 'required',
                'qty' => 'required',
                'order' => 'required',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'Item_id' => 'required',
                'date' => 'required',
                'customer_information' => 'required',
                'qty' => 'required',
                'order' => 'required',
            ]);
        }

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()], 200);
        }

        $cust = Customer::insertGetId(
            [
                'name' => $request->namec,
                'no_wa' => $request->no_wa,
                'orign' => $request->orign,
                'created_by' => $request->created_by,
            ]
        );

        if ($request->description1 == '') {
            $des = $request->description;
        } else {
            $des = $request->description1;
        }
        Laporan::updateOrCreate(
            ['id' => $request->Item_id],
            [
                'date' => $request->date,
                'customer_information' => $request->customer_information,
                'no_wa' => $request->no_wa,
                'id_customer' => $cust,
                'qty' => $request->qty,
                'order' => $request->order,
                'description' => $des,
                'source' => $request->source,
                'created_by' => $request->created_by,
            ]
        );

        // dd($lap);

        return response()->json(['success' => 'Item store successfully.']);
    }

    public function edit($id)
    {
        $item = Laporan::find($id);

        return response()->json($item);
    }

    public function destroy($id)
    {
        Laporan::find($id)->delete();

        return Response()->json(['success' => 'Laporan Berhasil dihapus']);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'date' => 'requi red',
            'customer_information' => 'required',
            // 'id_customer' => 'required',
            'qty' => 'required',
            'order' => 'required',
            'description' => 'required',
            'source' => 'required',
        ]);
        $input = $request->all();

        $item = Laporan::find($id);
        $item->update($input);

        return redirect()->route('laporan.index')
            ->with('success', 'laporan updated successfully');
    }

    public function export_excel()
    {
        return Excel::download(new LaporanExport(), 'Lead.xlsx');
    }
}
