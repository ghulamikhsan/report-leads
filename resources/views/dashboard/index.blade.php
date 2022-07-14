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
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="card-title">Total Lead
                                    </h2>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <a class="btn btn-lg btn-icon waves-effect waves-light btn-danger">
                                        <i class="fas fa-sticky-note nav-icon "></i>
                                    </a>
                                    <h4 class="font-weight-normal pt-2 mb-1 float-md-right">{{ $lead_counts }}</h4>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="card-title">Jumlah Customer Tanggal {{ $hari }} {{ $i_bulan }}
                                        {{ $tahun }}
                                    </h2>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <a class="btn btn-lg btn-icon waves-effect waves-light btn-success">
                                        <i class="fas fa-calendar-day nav-icon "></i>
                                    </a>
                                    <h4 class="font-weight-normal pt-2 mb-1 float-md-right">{{ $customer_d_counts }}</h4>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="card-title">Jumlah Customer Bulan {{ $i_bulan }}</h2>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <a class="btn btn-lg btn-icon waves-effect waves-light btn-warning">
                                        <i class="fas fa-calendar nav-icon "></i>
                                    </a>
                                    <h4 class="font-weight-normal pt-2 mb-1 float-md-right">{{ $customer_M_counts }}</h4>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="card-title">Total Customer</h2>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <a class="btn btn-lg btn-icon waves-effect waves-light btn-primary">
                                        <i class="fas fa-user-alt nav-icon"></i>
                                    </a>
                                    <h4 class="font-weight-normal pt-2 mb-1 float-md-right">{{ $customer_counts }}</h4>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="card-title">Grafik Total Keseluruhan Lead</h2>
                                </div>
                                <div class="card-body">
                                    <div id="chart"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="card-title">Grafik Total Lead Bulan {{ $i_bulan }}</h2>
                                </div>
                                <div class="card-body">
                                    <div id="chart2"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="card-title">Grafik Total Lead Per Bulan</h2>
                                </div>
                                <div class="card-body">
                                    <div id="chart3"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="card-title">Data Leads Bulan {{ $i_bulan }}</h2>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example2" class="table table-bordered table-hover data-table table-responsive">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Nama Customer</th>
                                                <th>Nomor Whatsapp</th>
                                                <th>Informasi Customer</th>
                                                <th>Pesanan</th>
                                                <th>QTY</th>
                                                <th>Keterangan</th>
                                                <th>Marketing</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($reports as $report)
                                                <tr>
                                                    <td>{{ date('d-m-Y', strtotime($report->date)) }}</td>
                                                    <td>{{ $report->name }}</td>
                                                    <td>{{ $report->no_wa }}</td>
                                                    <td>{{ $report->customer_information }}</td>
                                                    <td>{{ $report->order }}</td>
                                                    <td>{{ $report->qty }}</td>
                                                    <td>{{ $report->description }}</td>
                                                    @if ($report->uname == 'vira')
                                                        <td bgcolor="#00C1FE">{{ $report->uname }}</td>
                                                    @else
                                                        <td bgcolor="#32EF69">{{ $report->uname }}</td>
                                                    @endif
                                                    {{-- <td>{{ $report->uname }}</td> --}}
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
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
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
                    responsive: true
                });
            });

        });
        var options = {
            series: [{
                name: {!! $chart_vira !!},
                data: {!! $chart_t_customer_vira !!}
            }, {
                name: {!! $chart_luluk !!},
                data: {!! $chart_t_customer_luluk !!}
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            colors: ['#00C1FE', '#32EF69'],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: ['Lead'],
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return +val + ""
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();

        var options2 = {
            series: [{
                name: {!! $chart_vira !!},
                data: {!! $chart_tb_customer_vira !!}
            }, {
                name: {!! $chart_luluk !!},
                data: {!! $chart_tb_customer_luluk !!}
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            colors: ['#00C1FE', '#32EF69'],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: ['Lead'],
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return +val + ""
                    }
                }
            }
        };

        var chart2 = new ApexCharts(document.querySelector("#chart2"), options2);
        chart2.render();

        var options3 = {
            series: [{
                name: {!! $chart_vira !!},
                data: {!! $chart_p_bulan_vira !!},
            }, {
                name: {!! $chart_luluk !!},
                data: {!! $chart_p_bulan_luluk !!},
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            colors: ['#00C1FE', '#32EF69'],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: {!! $s_bulan !!},
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return +val + ""
                    }
                }
            }
        };

        var chart3 = new ApexCharts(document.querySelector("#chart3"), options3);
        chart3.render();
    </script>
@endsection
