@extends('layout.main')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!-- <h1 class="m-0">Data Pengguna Sistem</h1> -->
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
                                        {{-- <td>{{ count(explode(',', $d->purchase_requisition_number)) }}</td> --}}
                                        {{-- <td>{{ $d->purchase_requisition_number->count() }}</td> --}}
                                        <td>
                                            <a href="{{ route('detailPR', ['purchasing_document_number' =>          $d->purchasing_document_number]) }}" class="btn btn-sm btn-info"><i class="fas fa-info-circle"></i></a>
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
    

    <script>
        $(document).ready(function() {
            $('#soptabel').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,

                
                dom: 'Bfrtip',
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