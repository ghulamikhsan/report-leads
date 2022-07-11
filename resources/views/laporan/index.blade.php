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
                                    <h2 class="card-title">Management Detail Laporan Bulan Ini</h2>
                                    @can('user-create')
                                        <button type="button"
                                            class="btn btn-outline-primary btn-sm waves-effect waves-light float-right"
                                            id="createNewItem">Buat Laporan Customer Baru</button>
                                        <button type="button"
                                            class="btn btn-outline-primary btn-sm waves-effect waves-light float-right"
                                            id="createNewItem2">Buat Laporan Customer Lama</button>
                                    @endcan
                                </div>
                                <div class="card-header">
                                    <a href="export" class="btn btn-success btn-sm" target="_blank">Export Excel</a>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example2" class="table table-bordered table-hover data-table">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Nama Customer</th>
                                                <th>Nomor Whatsapp</th>
                                                <th>Informasi Customer</th>
                                                <th>QTY</th>
                                                <th>Pesanan</th>
                                                <th>Keterangan</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

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
    @can('user-create')
        <div class="modal fade" id="ajaxModel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modelHeading"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="ItemForm" name="ItemForm" class="form-horizontal">
                            <input type="hidden" name="Item_id" id="Item_id">
                            <input type="hidden" name="created_by" id="created_by" value="{{ auth()->user()->id }}">
                            <input type="hidden" name="customer_information" value="Baru" class="form-control" readonly>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label>Tanggal</label>
                                            {!! Form::date('date', null, ['placeholder' => 'Tanggal', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Nama Customer</label>
                                            {!! Form::text('namec', null, ['placeholder' => 'Nama Customer', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Nomor Whatsapp</label>
                                            {!! Form::number('no_wa', null, ['placeholder' => 'Nomor Whatsapp', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label>Alamat Asal</label>
                                            {!! Form::text('orign', null, ['placeholder' => 'Alamat Asal', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label>QTY</label>
                                            {!! Form::number('qty', null, ['placeholder' => 'QTY', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-12">
                                        <div class="form-group">
                                            <label>Pesanan</label>
                                            {!! Form::text('order', null, ['placeholder' => 'Pesanan', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Keterangan</label>
                                            {!! Form::text('description', null, ['placeholder' => 'Keterangan', 'class' => 'form-control']) !!}
                                        </div>
                                    </div> --}}
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label>Pilih Keterangan</label>
                                            <select name="payFor" id="payFor" class="form-control">
                                                <option disabled selected value>-</option>
                                                <option value="service">Template</option>
                                                <option value="product">Custom</option>
                                            </select>
                                            <br><div style="display: none;" id="services">
                                                <select name="description1" id="description1" class="form-control">
                                                    <option disabled selected value>-</option>
                                                    <option value="Deal">Deal</option>
                                                    <option value="Penawaran">Penawaran</option>
                                                    <option value="Tunggu Info">Tunggu Info</option>
                                                    <option value="Dibawah Minimal">Dibawah Minimal</option>
                                                </select>
                                                {{-- <input type="text" name="description1" id="description1" class="form-control"> --}}
                                            </div>
                                            <div style="display: none;" id="products">
                                                <select name="productId">
                                                    <option disabled selected value>-</option>
                                                    {{-- {!! Form::text('description', null, ['placeholder' => 'Keterangan', 'class' => 'form-control']) !!} --}}
                                                    <input type="text" name="description" id="description" class="form-control">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-offset-2 col-sm-10">
                                <button class="btn btn-primary tombol" id="saveBtn" value="create"></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ajaxModel2" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modelHeading2"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="ItemForm2" name="ItemForm2" class="form-horizontal">
                            <input type="hidden" name="Item_id" id="Item_id" value="">
                            <input type="hidden" name="created_by" id="created_by" value="{{ auth()->user()->id }}">
                            <input type="hidden" name="customer_information" value="Lama" class="form-control" readonly>
                            {{-- <input type="hidden" name="no_wa" id="no_wa" value="{{ auth()->customer()->id()->no_wa }}"> --}}
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label>Tanggal</label>
                                            {!! Form::date('date', null, ['placeholder' => 'Tanggal', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label>Nama Customer</label>
                                            {{-- {!! Form::select('name', $customers, ['placeholder' => 'Nama Customer', 'class' => 'form-control']) !!} --}}
                                            <select id="id_customer" name="id_customer" class="selectpicker form-control"
                                                data-live-search="true">
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label>QTY</label>
                                            {!! Form::number('qty', null, ['placeholder' => 'QTY', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-12">
                                        <div class="form-group">
                                            <label>Pesanan</label>
                                            {!! Form::text('order', null, ['placeholder' => 'Pesanan', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Keterangan</label>
                                            {!! Form::text('description', null, ['placeholder' => 'Keterangan', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-offset-2 col-sm-10">
                                <button class="btn btn-primary tombol" id="saveBtn2" value="create"></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endcan
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
        let bulan = $("#bulan").val()
        document.getElementById('payFor').addEventListener("change", function(e) {
            if (e.target.value === 'product') {
                document.getElementById('services').style.display = 'none';
                document.getElementById('products').style.display = 'block';
            } else {
                document.getElementById('products').style.display = 'none';
                document.getElementById('services').style.display = 'block'
            }
        });
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                // ajax: "{{ route('laporan.index') }}",
                ajax: {
                    url: "{{ route('laporan.index') }}",
                    //   type: "POST",
                    data: function(d) {
                        d.bulan = bulan;
                        console.log(d);
                        return d;
                    }
                },
                pageLength: 10,
                lengthMenu: [5, 10, 20, 50, 100, 200, 500],
                esponsive: true,
                lengthChange: false,
                autoWidth: false,
                columns: [{
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'customer_name',
                        name: 'customer_name'
                    },
                    {
                        data: 'number',
                        name: 'number'
                    },
                    {
                        data: 'customer_information',
                        name: 'customer_information'
                    },
                    {
                        data: 'qty',
                        name: 'qty'
                    },
                    {
                        data: 'order',
                        name: 'order'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('#createNewItem').click(function() {
                $('#saveBtn').val("create-Item");
                $('#Item_id').val('');
                $('#ItemForm').trigger("reset");
                $('#modelHeading').html("Buat Laporan Customer Baru");
                $('.tombol').html("Submit");
                $('#ajaxModel').modal('show');
            });
            $('#createNewItem2').click(function() {
                $('#saveBtn2').val("create-Item");
                $('#Item_id').val('');
                $('#ItemForm2').trigger("reset");
                $('#modelHeading2').html("Buat Laporan Customer Lama");
                $('.tombol').html("Submit");
                $('#ajaxModel2').modal('show');
            });

            // @can('user-create')
            //     $('body').on('click', '.editItem', function() {
            //         var Item_id = $(this).data('id');
            //         $('.tombol').html("Save Change");
            //         $.get("{{ route('laporan.index') }}" + '/' + Item_id + '/edit', function(data) {
            //             $('#modelHeading').html("Edit Item");
            //             $('#saveBtn').val("edit-laporan");
            //             $('#ajaxModel').modal('show');
            //             $('#Item_id').val(data.id);
            //             $('input[name=date]').val(data.date);
            //             $('input[name=customer_name]').val(data.customer_name);
            //             $('input[name=number]').val(data.number);
            //             $('input[name=order]').val(data.order);
            //             $('input[name=id_customer]').val(data.id_customer);
            //             $('input[name=qty]').val(data.qty);
            //             $('input[name=description]').val(data.description);
            //             $('input[name=created_by]').val(data.created_by);
            //         })
            //     });

            $('#saveBtn').click(function(e) {
                e.preventDefault();
                $.ajax({
                    data: $('#ItemForm').serialize(),
                    url: "{{ route('laporan.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: "success",
                                title: "Selamat",
                                text: response.success
                            });
                            $('#ItemForm').trigger("reset");
                            $('#ajaxModel').modal('hide');
                            table.draw();
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Mohon Maaf !",
                                text: response.error
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong!"
                        });
                    }
                });
            });

            $('body').on('click', '.editItem', function() {
                var Item_id = $(this).data('id');
                $('.tombol').html("Save Change");
                $.get("{{ route('laporan.index') }}" + '/' + Item_id + '/edit', function(data) {
                    $('#modelHeading2').html("Edit Item");
                    $('#saveBtn2').val("edit-laporan");
                    $('#ajaxModel2').modal('show');
                    $('input[name=Item_id]').val(data.id);
                    $('input[name=date]').val(data.date);
                    $('input[name=name]').val(data.id_customer);
                    $('input[name=number]').val(data.number);
                    $('input[name=order]').val(data.order);
                    $('input[name=qty]').val(data.qty);
                    $('input[name=description]').val(data.description);
                    $('input[name=created_by]').val(data.created_by);
                })
            });

            $('#saveBtn2').click(function(e) {
                e.preventDefault();
                $.ajax({
                    data: $('#ItemForm2').serialize(),
                    url: "{{ route('laporancustlama.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: "success",
                                title: "Selamat",
                                text: response.success
                            });
                            $('#ItemForm2').trigger("reset");
                            $('#ajaxModel2').modal('hide');
                            table.draw();
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Mohon Maaf !",
                                text: response.error
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong!"
                        });
                    }
                });
            });
        @endcan

        @can('user-delete')
            $('body').on('click', '.deleteItem', function() {

                var Item_id = $(this).data("id");
                var url = $(this).data("url");
                Swal.fire({
                    title: 'Apakah Anda Yakin ?',
                    text: "Anda Akan Menghapus Data Ini !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: url,
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: "success",
                                        title: "Selamat",
                                        text: response.success
                                    });
                                    $('#ItemForm').trigger("reset");
                                    $('#ajaxModel').modal('hide');
                                    table.draw();
                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Mohon Maaf !",
                                        text: response.error
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: "Something went wrong!"
                                });
                            }
                        });
                    }
                })
            });
        @endcan
        });
    </script>
@endsection
