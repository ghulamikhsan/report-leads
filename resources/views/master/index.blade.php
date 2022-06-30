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
                                    <a class="btn btn-outline-primary btn-sm waves-effect waves-light float-right" href="{{ 'laporan' }}"> Lihat Detail Penjualan</a>
                                </div>
                                <!-- /.card-header -->
                                @php
                                    $today = today(); 
                                    $dates = [];

                                    for($i=1; $i < $today->daysInMonth + 1; ++$i) {
                                        $dates[] = \Carbon\Carbon::createFromDate($today->year, $today->month, $i)->format('Y-m-d');
                                    }
                                    
                                    $bulan = $today->month;
                                @endphp
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 offset-md-4">
                                            <form type="get" action="#">
                                            {{-- <label>Search by Date</label>
                                                <input type="date"> - 
                                                <input type="date">
                                                <button type="submit" class="btn btn-outline-primary btn-sm waves-effect waves-light float-right" href='#'></button>Search</button>   --}}
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="example" class="table table-bordered table-hover data-table">
                                        <thead>
                                            <!--<tr>-->
                                            <!--    <th >Tanggal</th>-->
                                            <!--    <th>Keterangan Customer</th>-->
                                            <!--</tr>-->
                                             <tr>
                                                <th width="10%">Tanggal</th>
                                                <th>Lama</th>
                                                <th>Baru</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i= 0; $j = 0; ?>
                                             @foreach ($dates as $date)
                                                <tr>
                                                    <td>{{ date('d-m-Y', strtotime($date)) }}</td>
                                                    <?php $clama = $counts_lama->where('date',$date)->first();?>
                                                    <?php $cbaru = $counts_baru->where('date',$date)->first();?>
                                                    
                                                    @if (empty($clama->status))
                                                        <td class="table-danger"></td>
                                                    @else
                                                        <td>{{ $clama->status}} Lama</td>
                                                    @endif  
                                                    
                                                    @if (empty($cbaru->status))
                                                        <td class="table-danger"></td>
                                                    @else
                                                        <td>{{ $cbaru->status}} Baru</td>
                                                    @endif  
                                                </tr>
                                            @endforeach 
                                        </tbody>
                                    </table>
                                </div>
                                <!--<div class="card-body">-->
                                <!--    <table id="example2" class="table table-bordered table-hover data-table">-->
                                <!--        <thead>-->
                                <!--            <tr>-->
                                <!--                <th >Tanggal</th>-->
                                <!--                <th>Keterangan Customer</th>-->
                                <!--            </tr>-->
                                <!--        </thead>-->
                                <!--        <tbody>-->
                                <!--            {{-- @foreach ($dates as $date)-->
                                <!--                <tr>-->
                                <!--                    <td>{{ $date }}</td>-->
                                <!--                    @foreach ($counts_lama as $lama)-->
                                <!--                    @if ($lama->date==$date)-->
                                <!--                    <td>{{ $lama->status}} Lama</td>-->
                                <!--                    @elseif ($lama->status!='Lama')-->
                                <!--                    <td class="table-danger"></td>-->
                                <!--                    @else-->
                                <!--                    @endif   -->
                                <!--                    @endforeach-->
                                                    
                                <!--                    @foreach ($counts_baru as $baru)-->
                                <!--                    @if ($baru->date==$date)-->
                                <!--                    <td>{{ $baru->status}} Baru</td>-->
                                <!--                    @elseif ($baru->status!='Baru')-->
                                <!--                    <td class="table-danger"></td>-->
                                <!--                    @else-->
                                <!--                    @endif   -->
                                <!--                    @endforeach-->
                                <!--                </tr>-->
                                <!--            @endforeach --}}-->
                                <!--            @foreach ($counts_baru as $baru)-->
                                <!--                <tr>-->
                                <!--                    <td>{{ date('d-m-Y', strtotime(  $baru->date)) }}</td>-->
                                <!--                    <td>{{ $baru->status }} Baru</td>-->
                                <!--                </tr>-->
                                <!--            @endforeach-->
                                <!--        </tbody>-->
                                <!--    </table>-->
                                <!--</div>-->
                                <div class="modal fade" id="ajaxModel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="modelHeading"></h4>
                                            </div>
                                            <div class="modal-body">
                                                <form id="ReportForm" name="ReportForm" class="form-horizontal">
                                                   <input type="hidden" name="Report_id" id="Report_id">
                                                    <div class="form-group">
                                                        <label for="date" class="col-sm-2 control-label">Tanggal</label>
                                                        <div class="col-sm-12">
                                                            <input type="date" class="form-control" id="date" name="date" placeholder="Masukan Tanggal" value="" maxlength="50" required="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Lead</label>
                                                        <div class="col-sm-12">
                                                            <textarea id="lead" name="lead" required="" placeholder="Lead" class="form-control"></textarea>
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

            $('#example').DataTable();
            $('#example2').DataTable();

        $('#createNewReport').click(function () {
        $('#saveBtn').val("create-Report");
        $('#Report_id').val('');
        $('#ReportForm').trigger("reset");
        $('#modelHeading').html("Buat Laporan");
        $('#ajaxModel').modal('show');
    });

    $('body').on('click', '.editItem', function () {
      var Report_id = $(this).data('id');
      $.get("{{ route('laporan.index') }}" +'/' + Report_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Report");
          $('#saveBtn').val("edit-Report");
          $('#ajaxModel').modal('show');
          $('#Report_id').val(data.id);
          $('#date').val(data.date);
          $('#description').val(data.description);
      })
   });

   $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
    
        $.ajax({
          data: $('#ReportForm').serialize(),
          url: "{{ route('laporan.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
              if (data.success) {
                  swal.fire({
                      icon:"success",
                      title: "Laporan Berhasil Ditambahkan",
                      text: data.sucess
                  });
              $('#ReportForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
              } else {
                  swal.fire({
                      icon:"error",
                      title: "Mohon Maaf Laporan Gagal Ditambahkan",
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
     
     var Report_id = $(this).data("id");
     confirm("Are You sure want to delete !");
   
     $.ajax({
         type: "DELETE",
         url: "{{ route('laporan.store') }}"+'/'+Report_id,
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