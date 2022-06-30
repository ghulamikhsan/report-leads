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
                                    <h2 class="card-title">Management Customer</h2>
                                    <a class="btn btn-outline-primary btn-sm waves-effect waves-light float-right" href="javascript:void(0)" id="createNewCustomer"> Buat Customer Baru</a>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example2" class="table table-bordered table-hover data-table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    No
                                                </th>
                                                <th>Nama</th>
                                                <th>Nomor Whatsapp</th>
                                                <th>Alamat</th>
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
                                                <form id="CustomerForm" name="CustomerForm" class="form-horizontal">
                                                   <input type="hidden" name="Customer_id" id="Customer_id">
                                                    <div class="form-group">
                                                        <label for="name" class="col-sm-2 control-label">Nama</label>
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" id="name" name="name" placeholder="Masukan Nama" value="" maxlength="50" required="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Nomor Whatsapp</label>
                                                        <div class="col-sm-12">
                                                            <input id="no_wa" name="no_wa" required="" placeholder="Nomor Whatsapp" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Alamat</label>
                                                        <div class="col-sm-12">
                                                            <input id="orign" name="orign" required="" placeholder="Alamat" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-offset-2 col-sm-10">
                                                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
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
                processing: true,
                serverSide: true,
                ajax: "{{ route('customer.index') }}",
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
                        data: 'no_wa',
                        name: 'no_wa'
                    },
                    {
                        data: 'orign',
                        name: 'orign'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

        $('#createNewCustomer').click(function () {
        $('#saveBtn').val("create-Customer");
        $('#Customer_id').val('');
        $('#CustomerForm').trigger("reset");
        $('#modelHeading').html("Tambah Customer");
        $('#ajaxModel').modal('show');
    });

    $('body').on('click', '.editItem', function () {
      var Customer_id = $(this).data('id');
      $.get("{{ route('customer.index') }}" +'/' + Customer_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Report");
          $('#saveBtn').val("edit-Customer");
          $('#ajaxModel').modal('show');
          $('#Customer_id').val(data.id);
          $('#name').val(data.name);
          $('#no_wa').val(data.no_wa);
          $('#orign').val(data.orign);
      })
   });

   $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
    
        $.ajax({
          data: $('#CustomerForm').serialize(),
          url: "{{ route('customer.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
              if (data.success) {
                  swal.fire({
                      icon:"success",
                      title: "Customer Berhasil Ditambahkan",
                      text: data.sucess
                  });
              $('#CustomerForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
              } else {
                  swal.fire({
                      icon:"error",
                      title: "Mohon Maaf Customer Gagal Ditambahkan",
                      text: data.success
                  });
              }
          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Save Changes');
          }
      });
    });
    $('body').on('click', '.deleteItem', function () {
     
     var Customer_id = $(this).data("id");
     confirm("Are You sure want to delete !");
   
     $.ajax({
         type: "DELETE",
         url: "{{ route('customer.store') }}"+'/'+Customer_id,
         success: function (data) {
             table.draw();
         },
         error: function (data) {
             console.log('Error:', data);
         }
     });
    });
});
    </script>
@endsection