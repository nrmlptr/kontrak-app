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
                        <li class="breadcrumb-item active">Review Kontrak</li>
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
                            <h3 class="card-title">Review Data Kontrak</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <a class="btn btn-primary mb-2" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-filter"></i>
                                Filter Data
                            </a>
                            <a href="{{ route('rKontrak') }}" class="btn btn-warning mb-2" title="Refresh Data"><i class="fas fa-sync-alt"></i></a>
                            <div class="collapse" id="collapseExample">
                                <form action="{{ route('rKontrak') }}" method="GET">
                                @csrf
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="">Nama Vendor</label>
                                            <input type="text" name="nm_vendor" id="filter-nama-vendor" class="form-control filter">
                                        </div>
                                        {{-- <div class="col-md-2 mb-3">
                                            <label for="">Status</label>
                                            <select name="status" id="filter-status" class="form-control filter">
                                                <option value="">Pilih Status</option>
                                                <option value="draft">Draft</option>
                                                <option value="reviewkasek">Review By Kasek</option>
                                                <option value="revisikasek">Revisi By Kasek</option>
                                                <option value="editedkasek">Diperiksa Ulang Kasek</option>
                                                <option value="approvedkasek">Disetujui by Kasek</option>
                                                <option value="reviewkadept">Review By Kadept</option>
                                                <option value="revisikadept">Revisi By Kadept</option>
                                                <option value="editedkadept">Diperiksa Ulang Kasek</option>
                                                <option value="approvedkadept">Disetujui by Kadept</option>
                                                <option value="reviewkadiv">Review By Kadiv</option>
                                                <option value="revisikadiv">Revisi By Kadiv</option>
                                                <option value="editedkadiv">Diperiksa Ulang Kasek</option>
                                                <option value="approvedkadiv">Disetujui Kadiv (NET)</option>
                                            </select>
                                        </div> --}}
                                        <div class="col-md-2 mb-3">
                                            <label for="">Status</label>
                                            <select name="status" id="filter-status" class="form-control filter">
                                                <option value="">Pilih Status</option>
                                                <option value="draft">Draft</option>
                                                <option value="konsep">Konsep</option>
                                                <option value="review">Review</option>
                                                <option value="revisi">Revisi</option>
                                                <option value="edited">Review Ulang Kasek</option>
                                                <option value="approved">Approved</option>
                                                <!-- tambahkan opsi lainnya jika perlu -->
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="">Unit Kerja</label>
                                            <select name="unit_kerja" id="filter-unit-kerja" class="form-control filter">
                                                <option value="">Pilih Unit Kerja</option>
                                                <option value="41A10">Investasi</option>
                                                <option value="41A20">Jasa Barum</option>
                                                <option value="41A30">Lokal</option>
                                                <option value="41A40">Import</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="">Jenis Kontrak</label>
                                            <select name="jenis_kontrak" id="filter-jenis-kontrak" class="form-control filter">
                                                <option value="">Pilih Jenis Kontrak</option>
                                                <option value="1">Lumpsum</option>
                                                <option value="2">Harga Satuan</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="">Status Jaminan</label>
                                            <select name="status_jaminan" id="filter-status-jaminan" class="form-control filter">
                                                <option value="">Pilih Status Jaminan</option>
                                                <option value="1">Jaminan</option>
                                                <option value="2">Tanpa Jaminan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-12">
                                            <label for="">Tanggal SP</label>
                                            {{-- <hr> --}}
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
                                            {{-- <br> --}}
                                            <button type="submit" class="btn btn-primary" title="Search Data"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <table id="example1" class="table table-bordered table-striped">
                                <thead align="center">
                                    <tr>
                                        <th>Aksi</th>
                                        <th>No</th>
                                        <th style="width: 10%">Nomor Kontrak</th>
                                        <th>Tanggal Kontrak</th>
                                        <th>Nomor SOP</th>
                                        <th>Tanggal SOP</th>
                                        <th>Nama Vendor</th>
                                        <th>Perihal</th>
                                        <th>Pembuat</th>
                                        <th>Unit Kerja</th>
                                        <th>Jenis Kontrak</th>
                                        <th>Status Jaminan</th>
                                    </tr>
                                </thead>
                                <tbody align="center">
                                    @php
                                          $statuslist=['reviewkasek','reviewkadept','reviewkadiv'];
                                    @endphp
                                    @foreach($data as $d)
                                    <tr>
                                        <td>
                                            @if($d->status !== 'draft')
                                                <a href="{{ route('showKontrak', ['id' => $d->id]) }}" class="btn btn-sm btn-primary my-1" title="Detail Kontrak"><i class="fas fa-info-circle"></i></a>
                                                <br>
                                            @endif
                                            <a href="{{ route('logKontrak', ['id' => $d->id]) }}" class="logkontrak btn btn-sm btn-info my-1" title="History Kontrak"><i class="fas fa-history"></i></a><br>
                                            <a href="{{ route('historyRevisiK', ['id' => $d->id]) }}" class="historyRkontrak btn btn-sm btn-warning my-1" title="History Revisi"><i class="fas fa-list"></i></a><br>
                                            {{-- @if(Auth::user()->permission=='writer' || Auth::user()->permission=='admin') --}}
                                            @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('writer'))
                                                @php
                                                    $cekPembuat = Auth::user()->name;
                                                    $rkontrakexist=$d->revisiKontraks->pluck('user_id')->toArray();
                                                @endphp

                                                {{-- buat kondisi untuk admin dan writer karena ada tombol showRevisi jadi disitu dicek dlu apakah kontrak tersebut pembuatnya sama dengan name user yang lagi login? kalau iya, baru bisa showLampiran buat edit, kalau engga berarti forbidden --}}
                                                @if($d->pembuat == $cekPembuat || Auth::user()->hasRole('admin'))
                                                    {{-- JIKA DATA REVISI UNTUK KONTRAK TERSEBUT ADA --}}
                                                    @if(!empty($rkontrakexist))
                                                        {{-- cek lagi, jika statusnya belum disetujui kadiv, maka tampilkan tombol show revisi untuk nantinya edit data lampiran --}}
                                                        @if($d->status !== 'approvedkadiv')

                                                            <a href="{{ route('viewRevisi', ['id' => $d->id]) }}" class="btn btn-sm btn-secondary" title="Show Revisi"><i class="fas fa-eye"></i><br></a>
                                                            {{-- <a href="{{ route('editLampiran', ['id' => $d->id]) }}" class="btn btn-sm btn-warning"><i class="fas fa-pen"></i> Edit Lampiran</a> --}}

                                                        @else
                                                            <span class="badge badge-success">Kontrak selesai dibuat</span>
                                                        @endif
                                                    @else
                                                        <span class="badge badge-info">Tidak Ada Revisi</span>
                                                    @endif
                                                @else
                                                    <span class="badge badge-dark">Forbidden</span>
                                                @endif

                                            @endif
                                        </td>

                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $d->detail_number }}
                                            <br>
                                            @if($d->status == 'draft')
                                                <span class="badge badge-warning">Draft</span>
                                            @elseif($d->status == 'konsep')
                                                <span class="badge badge-warning">Konsep</span>
                                            @elseif($d->status == 'reviewkasek')
                                                <span class="badge badge-info">Review Kasek</span>
                                            @elseif($d->status == 'revisikasek')
                                                <span class="badge badge-danger">Revisi by Kasek</span>
                                            @elseif($d->status == 'editedkasek')
                                                <span class="badge badge-warning">Diperiksa ulang by Kasek</span>
                                            @elseif($d->status == 'approvedkasek')
                                                <span class="badge badge-success">Disetujui Kasek</span>
                                            @elseif($d->status == 'reviewkadept')
                                                <span class="badge badge-info">Review Kadept</span>
                                            @elseif($d->status == 'revisikadept')
                                                <span class="badge badge-danger">Revisi by Kadept</span>
                                            @elseif($d->status == 'editedkadept')
                                                <span class="badge badge-warning">Diperiksa ulang by Kasek</span>
                                            @elseif($d->status == 'approvedkadept')
                                                <span class="badge badge-success">Disetujui Kadept</span>
                                            @elseif($d->status == 'reviewkadiv')
                                                <span class="badge badge-info">Review Kadiv</span>
                                            @elseif($d->status == 'revisikadiv')
                                                <span class="badge badge-danger">Revisi by Kadiv</span>
                                            @elseif($d->status == 'editedkadiv')
                                                <span class="badge badge-warning">Diperiksa ulang by Kasek</span>
                                            @else
                                                <span class="badge badge-success">Disetujui Kadiv (NET)</span>
                                            @endif
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
        $(document).on('click','.logkontrak',function (e) {
            e.preventDefault();
            let href=$(this).attr('href')
            // console.log(href)
            winpopup(href,'logkontrak')
        });

        $(document).on('click','.historyRkontrak',function (e) {
            e.preventDefault();
            let href=$(this).attr('href')
            // console.log(href)
            winpopup(href,'historyRkontrak')
        });


        document.getElementById('filter-status').addEventListener('change', function() {
            let selectedStatus = this.value;

            // Ambil semua baris data (sesuaikan dengan struktur HTML Anda)
            let rows = document.querySelectorAll('.data-row');

            rows.forEach(row => {
                let status = row.getAttribute('data-status');

                // Pemetaan status spesifik ke status umum
                let statusMap = {
                    'draft': 'draft',
                    'konsep': 'konsep',
                    'reviewkasek': 'review',
                    'revisikasek': 'revisi',
                    'editedkasek': 'edited',
                    'approvedkasek': 'approved',
                    'reviewkadept': 'review',
                    'revisikadept': 'revisi',
                    'editedkadept': 'edited',
                    'approvedkadept': 'approved',
                    'reviewkadiv': 'review',
                    'revisikadiv': 'revisi',
                    'editedkadiv': 'edited',
                    'approvedkadiv': 'approved',
                    // tambahkan pemetaan lainnya jika perlu
                };

                let generalStatus = statusMap[status] || status;

                // Tampilkan atau sembunyikan baris berdasarkan filter
                if (selectedStatus === '' || generalStatus === selectedStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
@endpush
