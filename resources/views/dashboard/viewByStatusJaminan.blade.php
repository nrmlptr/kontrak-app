@extends('layout.main')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Kontrak Berdasarkan Status Jaminan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3 class="card-title"><b>Kontrak dengan Status Jaminan : </b>
                                    @if($statusJaminanInDB == 1)
                                        <span class="badge badge-info">Jaminan</span>
                                    @else
                                        <span class="badge badge-info">Tanpa Jaminan</span>
                                    @endif
                                </h3>
                            </div>

                            @if($contracts->isEmpty())
                                <div class="mt-3">
                                    <h4 class="text-center; color: red;">Tidak ada kontrak untuk Status Jaminan Ini.</h4>
                                </div>
                                <p>Tidak ada kontrak dengan status jaminan ini.</p>
                            @else
                                <div class="card-body">
                                    <table id="kontrakJaminandatatable" class="table table-bordered table-striped">
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
                                                    <td>{{ $d->detail_number }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($d->date_kontrak)) }}</td>
                                                    <td>{{ $d->nomor_sop }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($d->tanggal_sop)) }}</td>
                                                    <td>{{ $d->nm_vendor }}</td>
                                                    <td>{{ $d->perihal }}</td>
                                                    <td>{{ $d->pembuat }}</td>
                                                    <td>
                                                        @if($d->unit_kerja == '41A10')
                                                            Investasi
                                                        @elseif($d->unit_kerja == '41A20')
                                                            Jasa Baru
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
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#kontrakJaminandatatable').DataTable({
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
                        filename: 'Data_Kontrak_by_Status_Jaminan', // untuk nama filenya
                        title: 'Data Kontrak | Status Jaminan', //untuk di header nya
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                        }
                    },
                    {
                        extend: 'pdf',
                        filename: 'Data_Kontrak_by_Status_Jaminan', // untuk nama filenya
                        title: 'Data Kontrak | Status Jaminan', //untuk di header nya
                        orientation: 'landscape',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                        }
                    }
                ]
            });
        });
    </script>
@endpush
