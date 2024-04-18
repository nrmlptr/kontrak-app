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
                        <li class="breadcrumb-item active">Export Kontrak - Excel</li>
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
                            <h3 class="card-title">Export Kontrak</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                           <form action="{{ route('contracts.export') }}" method="GET">
                                <div class="form-group">
                                    <label for="label">Export Berdasarkan</label>
                                    <select name="filter_type" id="filter_type" class="form-control col-6">
                                        <option value="">All</option>
                                        <option value="date">Date</option>
                                        <option value="month">Month</option>
                                        <option value="year">Year</option>
                                    </select>
                                </div>

                                <!-- Input Bulan -->
                                <select name="month" id="month" class="form-control col-6 mt-2" style="display: none;">
                                    <option value="">Select Month</option>
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            
                                <!-- Tambahkan input untuk tahun -->
                                <input type="number" name="year" id="year" placeholder="Enter Year" autocomplete="off" class="form-control col-6 mt-2" style="display: none;" >

                                {{-- input ketika filter by tanggal, atau by tahun --}}
                                <input type="text" name="filter_value" id="filter_value" placeholder="Enter Value" autocomplete="off" class="form-control col-6 mt-2">

                                <button type="submit" class="btn btn-primary mt-2">Export Kontrak</button>
                            </form>
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
   
@endpush