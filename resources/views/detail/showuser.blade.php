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
                                    <h2 class="card-title">Management Detail Laporan </h2>
                                </div>
                                <div class="card-header">
                                    <div class="project-sort float-right">
                                    <div class="project-sort-item">
                                        <form class="form-inline">
                                            <!--<div class="form-group mr-2">-->
                                            <!--<label>Cari Berdasarkan Bulan :</label>-->
                                            <!--<select id="status" class="form-control" wire:model="month">-->
                                            <!--    <option value="0" selected>Pilih</option>-->
                                            <!--    <?php for ($i = 0; $i < count($tgl); $i++){?>-->
                                            <!--    <option value="{{ $tgl[$i]->nomonth}} {{ $tgl[$i]->year}}">{{ $tgl[$i]->month}} {{ $tgl[$i]->year}}</option>-->
                                            <!--    <?php }?>-->
                                              
                                            <!--</select>-->
                                            <!--    	    <button class="btn btn-info btn-sm ml-2" name="cari" type="submit" value="{{ $tgl[0]->nomonth}}" >Cari</button>-->
                                            <!--        </from>-->
                                            <!--    </form>-->
                                            <!--</div>-->
                                    </div>
                                </div>
                                </div>
                                <!-- /.card-header -->
                                
                                <div class="card-body">
                                    <table id="example2" class="table table-bordered table-hover data-table">
                                        <thead>
                                            <tr>
                                                {{-- <th class="text-center">
                                                    No
                                                </th> --}}
                                                <th>Tanggal</th>
                                                {{-- <th>Deal</th> --}}
                                                <th>Nama Customer</th>
                                                <th>Nomor Whatsapp</th>
                                                <th>Informasi Customer</th>
                                                <th>Pesanan</th>
                                                <th>QTY</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($laporans as $report)
                                                <tr>
                                                    <td>{{ date('d-m-Y', strtotime(  $report->date)) }}</td>
                                                    {{-- <td>{{ $report->deal }}</td> --}}
                                                    <td>{{ $report->name }}</td>
                                                    <td>{{ $report->no_wa }}</td>
                                                    <td>{{ $report->customer_information }}</td>
                                                    <td>{{ $report->order }}</td>
                                                    <td>{{ $report->qty }}  pcs</td>
                                                    <td>{{ $report->description }}</td>
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
                $('#example2').DataTable();
                $('#status').change(function() {
                dtTable.draw();
                })
            });
});
    </script>
@endsection