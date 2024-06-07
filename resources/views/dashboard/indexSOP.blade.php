@extends('layout.main')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Data SOP</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Main row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List Data SOP</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <a class="btn btn-primary mb-2" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" title="Filter Data"><i class="fas fa-filter"></i>
                                Filter Data
                            </a>
                            <a href="{{ route('indexSOP') }}" class="btn btn-warning mb-2" title="Refresh Data"><i class="fas fa-sync-alt"></i></a>
                            <div class="collapse" id="collapseExample">
                                <form action="{{ route('indexSOP') }}" method="GET">
                                @csrf
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="">Nama Vendor</label>
                                            <input type="text" name="nm_vendor" id="filter-nama-vendor" class="form-control filter" placeholder="Masukkan Nama Vendor">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="">No SOP</label>
                                            <input type="text" name="no_sop" id="filter-no-sop" class="form-control filter" placeholder="Masukkan Nomor SOP">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="">Perihal</label>
                                            <input type="text" name="perihal" id="filter-perihal" class="form-control filter" placeholder="Masukkan Perihal">
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-12">
                                            <label for="">Tanggal SOP</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="startdate">Start</label>
                                                <input type="date" class="form-control" name="startdate">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="enddate">End</label>
                                                <input type="date" class="form-control" name="enddate">
                                            </div>
                                        </div>
                                        <div class="col-md-4 mt-3 input-group-append">
                                            <button type="submit" class="btn btn-primary" title="Search Data"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <table id="soptabel" class="table table-bordered table-striped">
                                <thead align="center">
                                    <tr>
                                        <th>No</th>
                                        <th>Nomor SOP</th>
                                        <th>Tanggal SOP</th>
                                        <th>Perihal</th>
                                        <th>Nama Vendor</th>
                                        <th>Detail PR</th>
                                    </tr>
                                </thead>
                                <tbody align="center">
                                    @foreach($data as $d)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $d->purchasing_document_number }}</td>
                                            <td style="width: 12%;">{{ date('d-m-Y', strtotime($d->document_date)) }}</td>
                                            <td>{{ $d->tender_name }}</td>
                                            <td>{{ $d->vendor_name }}</td>
                                            <td>
                                                <a href="{{ route('detailPR', ['purchasing_document_number' =>          $d->purchasing_document_number]) }}" class="btn btn-sm btn-info" title="Detail PR"><i class="fas fa-info-circle"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

@endsection

@push('scripts')
    
    <script type="text/javascript">
        $(document).ready(function() {
            $('#soptabel').DataTable({
                "paging": true,
                "lengthChange": true,
                "pageLength": 5,
                "lengthMenu": [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'semua']],
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,

                
                dom: 'Bflrtip',
                buttons: [
                    {
                        extend: 'excel',
                        filename: 'Data_SOP_Dept_Pengadaan', // untuk nama filenya
                        title: 'Data SOP | Dept Pengadaan', //untuk di header nya
                        exportOptions: {
                            columns: [ 0,1,2,3,4]
                        }
                    },
                    {
                        extend: 'pdf',
                        filename: 'Data_SOP_Dept_Pengadaan', // untuk nama filenya
                        title: 'Data SOP | Dept Pengadaan', //untuk di header nya
                        orientation: 'landscape',
                        exportOptions: {
                            columns: [ 0,1,2,3,4]
                        }
                    }
                ]
            });
        });
    </script>

@endpush