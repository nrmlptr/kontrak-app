@extends('layout.main')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard v1</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- JUMLAH DATA KONTRAK -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $dataKontrak->count() }}</h3>
                                <p>Jumlah Kontrak</p>
                            </div>
                            <div class="icon">
                                <i class="nav-icon fas fa-copy"></i>
                            </div>
                            <a href="{{ route('indexKontrak') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $dataSOP->count() }}</h3>

                                <p>Jumlah SOP/PO/SPK</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a class="small-box-footer">Verified</a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $dataVendor->count() }}</h3>

                                <p>Jumlah Vendor</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a class="small-box-footer">Verified</a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $dataPasal->count() }}</h3>

                                <p>Jumlah Pasal</p>
                            </div>
                            <div class="icon">
                                <i class="nav-icon fas fa-book"></i>
                            </div>
                            <a href="#" class="small-box-footer">Verified</a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->
                <!-- Main row -->
                <div class="row">
                    <!-- Left col -->
                    <!-- kotak buat grafik tangki netralisasi -->
                    <div class="col-md-6 col-sm-6">
                        <div class="x_panel">
                            <div class="x_title">
                                <figure class="highcharts-figure">
                                    <div id="grafikStatus"></div>
                                </figure>
                            </div>
                        </div>
                    </div>  
                    <!-- kotak untuk grafik tangki outlet wwt -->
                    <div class="col-md-6 col-sm-6  ">
                        <div class="x_panel">
                            <div class="x_title">
                                <figure class="highcharts-figure">
                                    <div>
                                    <div id="kontrakperjenis"></div>
                                    </div>
                                </figure>
                            </div>
                        </div>
                    </div>   
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
{{-- HIGHCHARTS --}}
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
<script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/cylinder.js"></script>


<script type="text/javascript">

    // GRAFIK STATUS KONTRAK 
    $(document).ready(function() {
         Highcharts.chart('grafikStatus', {
            chart: {
                type: 'pie'
            },
            title: {
              text: 'GRAFIK STATUS KONTRAK'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.y}</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.y}',
                        style: {
                            fontSize: '1.2em',
                            textOutline: 'none',
                            opacity: 0.7
                        }
                    }
                }
            },
            series: [{
                name: 'Jumlah',
                colorByPoint: true,
                data: [
                    @foreach($dataStatus as $status => $count)
                        {
                            name: '{{ $status }}',
                            y: {{ $count }}
                        },
                    @endforeach
                ]
            }]
        });
    });

    // GRAFIK KONTRAK BY JENIS
    @php
        // Membuat array untuk kategori dan data
        $categories = [];
        $dataKontrak = [];

        // Iterasi melalui grup dan menambahkan data ke dalam array
        foreach ($KontrakPerJenis as $jenis => $jumlah) {
            if ($jenis == 1) {
                $categories[] = 'Jaminan';
            } elseif ($jenis == 2) {
                $categories[] = 'Tanpa Jaminan';
            }
            $dataKontrak[] = $jumlah;
        }

        // Menyiapkan data untuk dikirim ke view
        $dataGrafik = [
            'categories' => $categories,
            'dataKontrak' => $dataKontrak
        ];
    @endphp


    $(document).ready(function() {
        Highcharts.chart('kontrakperjenis', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'GRAFIK KONTRAK BERDASARKAN JENIS'
            },
            xAxis: {
                categories: {!! json_encode($dataGrafik['categories']) !!},
                crosshair: true,
                title: {
                    text: 'Jenis Kontrak'
                },
                // accessibility: {
                //     description: 'Jenis Kontrak'
                // }
            },
            yAxis: {
                min: 0,
                // max: 30,
                tickInterval: 1,
                title: {
                    text: 'Jumlah Kontrak'
                }
            },
            tooltip: {
                valueSuffix: ''
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                    colorByPoint: true // Mengaktifkan warna berdasarkan kategori
                }
            },
            series: [{
                name: 'Jumlah Kontrak',
                data: {!! json_encode($dataGrafik['dataKontrak']) !!}
            }],
            colors: ['#7cb5ec', '#90ed7d'] // Menentukan warna untuk setiap kategori
        });
    });

</script>