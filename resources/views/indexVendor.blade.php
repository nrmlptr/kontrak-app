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
                        <li class="breadcrumb-item active">Vendor Akta Setting</li>
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
                            <h3 class="card-title">Vendor List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <a class="btn btn-primary mb-2" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" title="Filter Data"><i class="fas fa-filter"></i>
                                Filter Data
                            </a>
                            <a href="{{ route('vendor.index') }}" class="btn btn-warning mb-2" title="Refresh Data"><i class="fas fa-sync-alt"></i></a>

                            <div class="collapse" id="collapseExample">
                                <form action="{{ route('vendor.index') }}" method="GET">
                                @csrf
                                    <div class="row">
                                         <div class="col-md-3 mb-3">
                                            <label for="">No Registration</label>
                                            <input type="text" name="no_regis" id="filter-no-registration" class="form-control filter">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="">No SOP</label>
                                            <input type="text" name="no_sop" id="filter-no-sop" class="form-control filter">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="">Nama Vendor</label>
                                            <input type="text" name="nm_vendor" id="filter-nama-vendor" class="form-control filter">
                                        </div>
                                        <div class="col-md-2 mb-3 mt-1 input-group-append">
                                            {{-- <br> --}}
                                            <button type="submit" class="btn btn-primary" title="Search Data"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                    
                                </form>
                            </div>



                            <table id="example3" class="table table-bordered table-striped">
                                <thead align="center">
                                    <tr>
                                       
                                        <th>No</th>
                                        <th>No Registration</th>
                                        <th>Purchasing Document Number</th>
                                        <th>Vendor Name</th>
                                        
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody align="center">
                                    @foreach($data as $d)
                                    <tr>
                                        
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $d->registration_no }}</td>
                                        <td>{{ $d->purchasing_document_number }}</td>
                                        <td>{{ $d->vendor_name }}</td>
                                       
                                       <td>
                                                        <a href="{{ route('vendor.edit',$d->registration_no) }}" class="btn btn-sm btn-warning"><i class="fas fa-pen"></i> Edit</a>
                                                    </td>
                                    </tr>
                                    
                                    <!-- /.modal -->
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