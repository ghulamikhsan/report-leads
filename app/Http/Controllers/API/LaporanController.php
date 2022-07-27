<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Laporan;

class LaporanController extends Controller
{
    public function index()
    {
        $laporans = Laporan::paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $laporans,
        ]);
    }
}
