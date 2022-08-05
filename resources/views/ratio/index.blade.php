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
                                    <h2 class="card-title">Management Rasio</h2>
                                    <a class="btn btn-outline-primary btn-sm waves-effect waves-light float-right"
                                        href="javascript:void(0)" id="createNewRatio"> Buat Rasio Iklan Baru</a>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example2" class="table table-bordered table-hover data-table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Bisnis</th>
                                                <th>Tanggal</th>
                                                <th>Omset</th>
                                                <th>Laba</th>
                                                <th>Budget Iklan</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal fade" id="ajaxModel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="modelHeading"></h4>
                                            </div>
                                            <div class="modal-body">
                                                <form id="RatioForm" name="RatioForm" class="form-horizontal">
                                                    <input type="hidden" name="Ratio_id" id="Ratio_id">
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group">
                                                            <label>Nama Bisnis</label>
                                                            <select name="name" id="name" class="form-control">
                                                                <option disabled selected value>-</option>
                                                                <option value="Moko Garment">Moko Garment
                                                                </option>
                                                                <option value="Sentra Handuk">Sentra Handuk</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group">
                                                            <label>Tanggal</label>
                                                            {!! Form::date('date', null, ['placeholder' => 'Tanggal', 'class' => 'form-control']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Omset</label>
                                                        <div class="col-sm-12">
                                                            <input id="turnover" name="turnover" required=""
                                                                placeholder="Omset" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Laba</label>
                                                        <div class="col-sm-12">
                                                            <input id="profit" name="profit" required=""
                                                                placeholder="Laba" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Budget Iklan</label>
                                                        <div class="col-sm-12">
                                                            <input id="adv_budget" name="adv_budget" required=""
                                                                placeholder="Budget Iklan" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-offset-2 col-sm-10">
                                                        <button type="submit" class="btn btn-primary" id="saveBtn"
                                                            value="create">Save changes
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
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

            var table = $('.data-table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('ratio.index') }}",
                pageLength: 10,
                lengthMenu: [5, 10, 20, 50, 100, 200, 500],
                esponsive: true,
                lengthChange: false,
                autoWidth: false,
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'turnover',
                        name: 'turnover',
                        render: $.fn.dataTable.render.number( '.', '.', 0, 'Rp ' )
                    },
                    {
                        data: 'profit',
                        name: 'profit',
                        render: $.fn.dataTable.render.number( '.', '.', 0, 'Rp ' )
                    },
                    {
                        data: 'adv_budget',
                        name: 'adv_budget',
                        render: $.fn.dataTable.render.number( '.', '.', 0, 'Rp ' )
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('#createNewRatio').click(function() {
                $('#saveBtn').val("create-Ratio");
                $('#Ratio_id').val('');
                $('#RatioForm').trigger("reset");
                $('#modelHeading').html("Tambah Ratio");
                $('#ajaxModel').modal('show');
            });

            $('body').on('click', '.editItem', function() {
                var Ratio_id = $(this).data('id');
                $.get("{{ route('ratio.index') }}" + '/' + Ratio_id + '/edit', function(data) {
                    $('#modelHeading').html("Edit Report");
                    $('#saveBtn').val("edit-Ratio");
                    $('#ajaxModel').modal('show');
                    $('#Ratio_id').val(data.id);
                    $('#name').val(data.name);
                    $('#date').val(data.date);
                    $('#turnover').val(data.turnover);
                    $('#profit').val(data.profit);
                    $('#adv_budget').val(data.adv_budget);
                })
            });

            $('#saveBtn').click(function(e) {
                e.preventDefault();
                $(this).html('Sending..');

                $.ajax({
                    data: $('#RatioForm').serialize(),
                    url: "{{ route('ratio.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        if (data.success) {
                            swal.fire({
                                icon: "success",
                                title: "Ratio Berhasil Ditambahkan",
                                text: data.sucess
                            });
                            $('#RatioForm').trigger("reset");
                            $('#ajaxModel').modal('hide');
                            table.draw();
                        } else {
                            swal.fire({
                                icon: "error",
                                title: "Mohon Maaf Ratio Gagal Ditambahkan",
                                text: data.success
                            });
                        }
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        $('#saveBtn').html('Save Changes');
                    }
                });
            });
            $('body').on('click', '.deleteItem', function() {

                var Ratio_id = $(this).data("id");
                confirm("Are You sure want to delete !");

                $.ajax({
                    type: "DELETE",
                    url: "{{ route('ratio.store') }}" + '/' + Ratio_id,
                    success: function(data) {
                        table.draw();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            });
        });
    </script>
@endsection
