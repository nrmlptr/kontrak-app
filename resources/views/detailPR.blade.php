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
                        <li class="breadcrumb-item"><a href="{{ route('indexSOP') }}">Back</a></li>
                        <li class="breadcrumb-item active">Detail PR</li>
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
                            <h3 class="card-title">Detail PR dari Nomor SOP : <b>{{ $purchasing_document_number }}</b></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                           <div class="table-responsive">
                            <table id="detailPRtabel" class="table table-hovered table-sm table-bordered">
                            <tr>
                                <td>
                                    <ul>
                                        <h6><u>Nomor Purchase Requisition</u></h6>
                                        @foreach ($purchaseRequisitions as $PR)
                                            <li>{{ $PR->purchase_requisition_number }}</li>
                                        @endforeach
                                    </ul>
                                                                      
                                </td>
                                <td>
                                    <h6><u>Nama Barang</u></h6>
                                    <ul>
                                        @foreach ($purchaseRequisitions as $PR)
                                            <li>{{ $PR->material_name }}</li>
                                        @endforeach
                                    </ul>  
                                </td>
                            </tr>
                           </table>
                           </div>
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
