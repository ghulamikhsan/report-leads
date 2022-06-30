<?php

namespace App\Exports;

use App\Models\bulan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Carbon;

class LaporanBulananExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $month;
    private $year;

    public function __construct(int $year, int $month)
    {
        $this->month = $month;
        $this->year  = $year;
    }
    
    public function collection()
    {
        // return Laporan::all();
        $bulan = Carbon::now()->format('m');
        return $data = bulan::join('customers', 'bulan.id_customer', '=', 'customers.id')
                ->join('users', 'bulan.created_by', '=', 'users.id')
                ->select('bulan.date', 'customers.name as customer_name', 'customers.no_wa as number', 'bulan.customer_information', 'bulan.qty', 'bulan.order', 'bulan.description')
                ->where('users.id', '=', auth()->user()->id)
                ->whereMonth('bulan.date',$this->month)
                ->whereYear('bulan.date',$this->year)
                ->orderBy('bulan.date')
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
}
