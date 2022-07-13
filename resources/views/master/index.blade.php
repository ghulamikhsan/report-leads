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
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="card-title">Management Laporan</h2>
                                    <a class="btn btn-outline-primary btn-sm waves-effect waves-light float-right"
                                        href="{{ 'laporan' }}"> Lihat Detail Penjualan</a>
                                </div>
                                <!-- /.card-header -->
                                @php
                                    $today = today();
                                    $dates = [];
                                    
                                    for ($i = 1; $i < $today->daysInMonth + 1; ++$i) {
                                        $dates[] = \Carbon\Carbon::createFromDate($today->year, $today->month, $i)->format('Y-m-d');
                                    }
                                    
                                    $bulan = $today->month;
                                @endphp
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 offset-md-4">
                                            <form type="get" action="#">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="example" class="table table-bordered table-hover data-table">
                                        <thead>
                                            <tr>
                                                <th width="10%">Tanggal</th>
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
@endsection

@section('js-tambahan')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('cdn/datatables/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('cdn/datatables/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('cdn/datatables/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('cdn/datatables/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('cdn/datatables/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('cdn/datatables/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script type="text/javascript">
        $(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#example').DataTable();
            $('#example2').DataTable();
        });
    </script>
@endsection
