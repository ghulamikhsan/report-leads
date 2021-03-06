@extends('layouts.dashboard.master')
@section('title')
    Management
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- breadcumb -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 float-right">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">{{ auth()->user()->name }}</a></li>
                            <li class="breadcrumb-item active">@yield('title')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="card-title">Management Detail Laporan Bulan
                                        {{ \Carbon\Carbon::parse($bln2->month)->translatedFormat('F') }}</h2>
                                </div>
                                <div class="card-header">
                                    <a href="/export_bulanan/{{ $bln->nomonth }}" class="btn btn-success btn-sm"
                                        target="_blank">Export Excel</a>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example2" class="table table-bordered table-hover data-table">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Nama Customer</th>
                                                <th>Informasi Customer</th>
                                                <th>Nomor Whatsapp</th>
                                                <th>QTY</th>
                                                <th>Pesanan</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($months as $item)
                                                <tr>
                                                    <td>{{ date('d-m-Y', strtotime($item->date)) }}</td>
                                                    <td>{{ $item->customer_name }}</td>
                                                    <td>{{ $item->customer_information }}</td>
                                                    <td>{{ $item->no_wa }}</td>
                                                    <td>{{ $item->qty }}</td>
                                                    <td>{{ $item->order }}</td>
                                                    <td>{{ $item->description }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="content-header">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="card-title">Detail Laporan Jumlah Customer Baru dan Lama Bulan
                                        {{ \Carbon\Carbon::parse($bln2->month)->translatedFormat('F') }}</h2>
                                </div>
                                <!-- /.card-header -->
                                @php
                                    $today = today();
                                    $tahun = date('Y', strtotime($item->date));
                                    $bulan = date('m', strtotime($item->date));
                                    $dates = [];
                                    
                                    for ($i = 1; $i < $today->daysInMonth + 1; ++$i) {
                                        $dates[] = \Carbon\Carbon::createFromDate($tahun, $bulan, $i)->format('Y-m-d');
                                    }
                                    
                                    $bulan = $today->month;
                                @endphp
                                <div class="card-body">
                                    <table id="example" class="table table-bordered table-hover data-table">
                                        <thead>
                                            <tr>
                                                <th width="9%">Tanggal</th>
                                                <th>Lama</th>
                                                <th>Baru</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 0;
                                            $j = 0; ?>
                                            @foreach ($dates as $date)
                                                <tr>
                                                    <td>{{ date('d-m-Y', strtotime($date)) }}</td>
                                                    <?php $clama = $counts_lama->where('date', $date)->first(); ?>
                                                    <?php $cbaru = $counts_baru->where('date', $date)->first(); ?>

                                                    @if (empty($clama->status))
                                                        <td class="table-danger"></td>
                                                    @else
                                                        <td>{{ $clama->status }} Lama</td>
                                                    @endif

                                                    @if (empty($cbaru->status))
                                                        <td class="table-danger"></td>
                                                    @else
                                                        <td>{{ $cbaru->status }} Baru</td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
        </div>
        </section>
    </div>
    <!-- /.content-header -->
    </div>
@endsection


@section('css-tambahan')
    <link rel="stylesheet" href="{{ asset('cdn/datatables/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('cdn/datatables/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('cdn/datatables/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endsection

@section('js-tambahan')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('cdn/datatables/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('cdn/datatables/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('cdn/datatables/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('cdn/datatables/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('cdn/datatables/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('cdn/datatables/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).ready(function() {
                $('select').select();
                $('#example2').DataTable({
                    responsive:true
                });
                $('#example').DataTable();
            });
        });
    </script>
@endsection
