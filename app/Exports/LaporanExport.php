<?php

namespace App\Exports;

use App\Models\Laporan;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class LaporanExport implements FromCollection, WithHeadings, WithColumnFormatting
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // return Laporan::all();
        $bulan = Carbon::now()->format('m');

        return $data = Laporan::join('customers', 'laporans.id_customer', '=', 'customers.id')
                ->join('users', 'laporans.created_by', '=', 'users.id')
                ->select('laporans.date', 'customers.name as customer_name', 'customers.no_wa as number', 'laporans.customer_information', 'laporans.qty', 'laporans.order', 'laporans.description')
                ->where('users.id', '=', auth()->user()->id)
                ->whereMonth('laporans.date', $bulan)
                ->orderBy('laporans.date')
                ->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama Customer',
            'Nomor Whatsapp',
            'Informasi Customer',
            'QTY',
            'Pesanan',
            'Keterangan',
            ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'B' => '@',
            'C' => '@',
            'D' => '@',
            'E' => '@',
            'F' => '@',
            'G' => '@',
        ];
    }
}
