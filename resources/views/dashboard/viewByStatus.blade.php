@extends('layout.main')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Back</a></li>
                            <li class="breadcrumb-item active">Data Kontrak</li>
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
                                <h3 class="card-title"><b>Kontrak dengan Status : </b>
                                    @if($statusInDB === 'draft')
                                        <span class="badge badge-info">Draft</span>
                                    @elseif($statusInDB === 'konsep')
                                        <span class="badge badge-info">Konsep</span>
                                    @elseif($statusInDB === 'reviewkasek')
                                        <span class="badge badge-info">Sedang Diperiksa Kasek</span>
                                    @elseif($statusInDB === 'revisikasek')
                                        <span class="badge badge-info">Direvisi oleh Kasek</span>
                                    @elseif($statusInDB === 'approvedkasek')
                                        <span class="badge badge-info">Disetujui Kasek</span>
                                    @elseif($statusInDB === 'reviewkadept')
                                        <span class="badge badge-info">Sedang Diperiksa Kadept</span>
                                    @elseif($statusInDB === 'revisikadept')
                                        <span class="badge badge-info">Direvisi oleh Kadept</span>
                                    @elseif($statusInDB === 'approvedkadept')
                                        <span class="badge badge-info">Disetujui Kadept</span>
                                    @elseif($statusInDB === 'reviewkadiv')
                                        <span class="badge badge-info">Sedang Diperiksa Kadiv</span>
                                    @elseif($statusInDB === 'revisikadiv')
                                        <span class="badge badge-info">Direvisi oleh Kadiv</span>
                                    @elseif($statusInDB === 'editedkasek')
                                        <span class="badge badge-info">Sedang Diperiksa Ulang Kasek</span>
                                    @elseif($statusInDB === 'editedkadept')
                                        <span class="badge badge-info">Sedang Diperiksa Ulang Kasek</span>
                                    @else
                                        <span class="badge badge-info">Sedang Diperiksa Ulang Kasek</span>
                                    @endif
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            @if($contracts->isEmpty())
                                <div class="mt-3">
                                    <h4 style="text-align: center; color: red;">Tidak Ada Kontrak dengan Status Ini.</h4></h4>
                                </div>
                            @else
                                <div class="card-body">
                                    <table id="viewByStatusdatatable" class="table table-bordered table-striped">
                                        <thead align="center">
                                            <tr>
                                                <th>No</th>
                                                <th>Nomor Kontrak</th>
                                                <th>Tanggal Kontrak</th>
                                                <th>Nomor SOP</th>
                                                <th>Tanggal SOP</th>
                                                <th>Nama Vendor</th>
                                                <th>Perihal</th>
                                                <th>Pembuat</th>
                                                <th>Unit Kerja</th>
                                                <th>Jenis Kontrak</th>
                                                <th>Status Jaminan</th>
                                                <th>Total Harga (Incl PPN)</th>
                                            </tr>
                                        </thead>
                                        <tbody align="center">
                                            @foreach($contracts as $d)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        {{ $d->detail_number }}

                                                    </td>
                                                    <td>{{ date('d-m-Y', strtotime($d->date_kontrak)) }}</td>
                                                    <td>{{ $d->nomor_sop }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($d->tanggal_sop)) }}</td>
                                                    <td>{{ $d->nm_vendor }}</td>
                                                    <td>{{ $d->perihal }}</td>
                                                    <td>{{ $d->pembuat }}</td>
                                                    <td>@if($d->unit_kerja == '41A10')
                                                            Investasi
                                                        @elseif($d->unit_kerja == '41A20')
                                                            Jasa Barum
                                                        @elseif($d->unit_kerja == '41A30')
                                                            Lokal
                                                        @else
                                                            Import
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($d->jenis_kontrak == '1')
                                                            <span class="badge badge-info">Lumpsum</span>
                                                        @else
                                                            <span class="badge badge-secondary">Harga Satuan</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($d->status_jaminan == '1')
                                                            <span class="badge badge-success">Jaminan</span>
                                                        @else
                                                            <span class="badge badge-secondary">Tanpa Jaminan</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ @formatRupiah($d->total_keseluruhan) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
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

            $('#viewByStatusdatatable').DataTable({
                "paging": true,
                "lengthChange": true,
                "pageLength": 5,
                "lengthMenu": [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'semua']],
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,

                dom: 'Bflrtip',
                buttons: [
                    {
                        extend: 'excel',
                        filename: 'Data_Kontrak_by_Progress_Status', // untuk nama filenya
                        title: 'Data Kontrak | Progress Status', //untuk di header nya
                        exportOptions: {
                            columns: [0,1,2,3,4,5,6,7,8,9,10,11]
                        }
                    },
                    {
                        extend: 'pdf',
                        filename: 'Data_Kontrak_by_Progress_Status', // untuk nama filenya
                        title: 'Data Kontrak | Progress Status', //untuk di header nya
                        orientation: 'landscape',
                        exportOptions: {
                            columns: [0,1,2,3,4,5,6,7,8,9,10,11]
                        }
                    }
                ]
            });
        });
    </script>

@endpush
