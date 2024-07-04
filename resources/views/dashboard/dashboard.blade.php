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
                            <li class="breadcrumb-item active">Dashboard</li>
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
                                <p><b>Jumlah Kontrak</b></p>
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

                                <p><b>Jumlah SOP/PO/SPK</b></p>
                            </div>
                            <div class="icon">
                                <i class="nav-icon fas fa-chart-bar"></i>
                            </div>
                            <a href="{{ route('indexSOP') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $dataKontrakAKDV->count() }}</h3>
                                <p><b>Kontrak Disetujui Kadiv</b></p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <a href="{{ route('KontrakAK') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $dataKontrakProses->count() }}</h3>

                                <p><b>Kontrak Dalam Proses</b></p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-tasks"></i>
                            </div>
                           <a href="{{ route('KontrakonProcess') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->

                <!-- Main row -->
                <div class="row">
                    
                    <!-- kotak buat grafik proses kontrak -->
                    <div class="col-md-12 col-sm-12">
                        <div class="x_panel"> 
                            <div class="x_title">
                                <figure class="highcharts-figure">
                                    <div id="grafikStatus"></div>
                                </figure>
                            </div>
                        </div>
                    </div>  
 
                </div>
                <div class="row">
                    <!-- kotak untuk grafik kontrak per status jaminan -->
                    <div class="col-md-6 col-sm-6  ">
                        <div class="x_panel">
                            <div class="x_title">
                                <figure class="highcharts-figure">
                                    <div>
                                    <div id="kontrakperstatusJaminan"></div>
                                    </div>
                                </figure>
                            </div>
                        </div>
                    </div>   
                    <!-- kotak buat grafik kontrak per jenis kontrak -->
                    <div class="col-md-6 col-sm-6">
                        <div class="x_panel">
                            <div class="x_title">
                                <figure class="highcharts-figure">
                                    <div id="grafikKontrakPerJK"></div>
                                </figure>
                            </div>
                        </div>
                    </div>  
                     
                </div>

                <div class="row">
                    <!-- kotak untuk grafik per nama vendor -->
                    <div class="col-md-12 col-sm-12  ">
                        <div class="x_panel">
                            <div class="x_title">
                                <figure class="highcharts-figure">
                                    <div>
                                    <div id="grafikKontrakperVendor"></div>
                                    </div>
                                </figure>
                            </div>
                        </div>
                    </div>  

                    <!-- kotak buat grafik kontrak per jenis kontrak -->
                    {{-- <div class="col-md-6 col-sm-6">
                        <div class="x_panel">
                            <div class="x_title">
                                <figure class="highcharts-figure">
                                    <div id=""></div>
                                </figure>
                            </div>
                        </div>
                    </div>   --}}
                    <!-- kotak untuk grafik per nama vendor -->
                    {{-- <div class="col-md-6 col-sm-6  ">
                        <div class="x_panel">
                            <div class="x_title">
                                <figure class="highcharts-figure">
                                    <div>
                                    <div id=""></div>
                                    </div>
                                </figure>
                            </div>
                        </div>
                    </div>    --}}
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
{{-- <script src="https://code.highcharts.com/highcharts.js"></script> --}}
<script src="{{ asset('assets/Highcharts/code/highcharts.js') }}"></script>
{{-- <script src="https://code.highcharts.com/modules/data.js"></script> --}}
<script src="{{ asset('assets/Highcharts/code/modules/data.js') }}"></script>
{{-- <script src="https://code.highcharts.com/modules/series-label.js"></script> --}}
<script src="{{ asset('assets/Highcharts/code/modules/series-label.js') }}"></script>
{{-- <script src="https://code.highcharts.com/modules/exporting.js"></script> --}}
<script src="{{ asset('assets/Highcharts/code/modules/exporting.js') }}"></script>
{{-- <script src="https://code.highcharts.com/modules/export-data.js"></script> --}}
<script src="{{ asset('assets/Highcharts/code/modules/export-data.js') }}"></script>
{{-- <script src="https://code.highcharts.com/modules/accessibility.js"></script> --}}
<script src="{{ asset('assets/Highcharts/code/modules/accessibility.js') }}"></script>
{{-- <script src="https://code.highcharts.com/highcharts-3d.js"></script> --}}
<script src="{{ asset('assets/Highcharts/code/highcharts-3d.js') }}"></script>
{{-- <script src="https://code.highcharts.com/modules/cylinder.js"></script> --}}
<script src="{{ asset('assets/Highcharts/code/modules/cylinder.js') }}"></script>



<script type="text/javascript">

    // GRAFIK STATUS KONTRAK =================================================================================================
    $(document).ready(function() {
        Highcharts.chart('grafikStatus', {
            chart: {
                type: 'pie'
            },
            title: {
              text: 'PROSES PEMBUATAN KONTRAK'
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
                    },
                    showInLegend: true
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

    // GRAFIK KONTRAK BY STATUS JAMINAN ======================================================================================
    @php
        // Membuat array untuk kategori dan data
        $categories = [];
        $dataKontrak = [];

        // Iterasi melalui grup dan menambahkan data ke dalam array
        foreach ($KontrakPerStatusJaminan as $statusJaminan => $jumlah) {
            if ($statusJaminan == 1) {
                $categories[] = 'Jaminan';
            } elseif ($statusJaminan == 2) {
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
        Highcharts.chart('kontrakperstatusJaminan', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'KONTRAK BERDASARKAN STATUS JAMINAN'
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
                    @foreach($dataGrafik['categories'] as $index => $category)
                        {
                            name: '{{ $category }}',
                            y: {{ $dataGrafik['dataKontrak'][$index] }}
                        },
                    @endforeach
                ]
            }]
        });
    });

    // GRAFIK KONTRAK BY JENIS KONTRAK =======================================================================================
    @php
        // Membuat array untuk kategori dan data
        $categories = [];
        $dataKontrak = [];

        // Iterasi melalui grup dan menambahkan data ke dalam array
        foreach ($KontrakperJenisKontrak as $Jeniskontrak => $jumlah) {
            if ($Jeniskontrak == 1) {
                $categories[] = 'Lumpsum';
            } elseif ($Jeniskontrak == 2) {
                $categories[] = 'Harga Satuan';
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
        Highcharts.chart('grafikKontrakPerJK', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'KONTRAK BERDASARKAN JENIS KONTRAK'
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
                    @foreach($dataGrafik['categories'] as $index => $category)
                        {
                            name: '{{ $category }}',
                            y: {{ $dataGrafik['dataKontrak'][$index] }}
                        },
                    @endforeach
                ]
            }]
        });
    });

    // GRAFIK KONTRAK TOP 10 VENDOR ==========================================================================================
    @php
        // Membuat array untuk kategori dan data
        $categories = [];
        $dataKontrak = [];

        // Iterasi melalui grup dan menambahkan data ke dalam array
        foreach ($topVendors as $vendor => $jumlah) {
            $categories[] = $vendor;
            $dataKontrak[] = $jumlah;
        }

        // Menyiapkan data untuk dikirim ke view
        $dataGrafik = [
            'categories' => $categories,
            'dataKontrak' => $dataKontrak
        ];
    @endphp


    $(document).ready(function() {
        Highcharts.chart('grafikKontrakperVendor', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'TOP 10 VENDOR DENGAN PEMBUATAN KONTRAK TERBANYAK'
            },
            xAxis: {
                categories: {!! json_encode($dataGrafik['categories']) !!},
                crosshair: true,
                title: {
                    text: 'Nama Vendor'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah Kontrak'
                }
            },
            tooltip: {
                // pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b><br/>',
                // shared: true
                enabled: false
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}', // Menampilkan jumlah kontrak
                        inside: true,
                        style: {
                            fontSize: '14px' // Ukuran teks
                        }
                    },
                    // colorByPoint: true, //aktifkan warna berdasarkan point
                    // colors: ['#7cb5ec'], // Warna yang sama untuk semua point
                }
            },
            series: [{
                name: 'Jumlah Kontrak',
                data: {!! json_encode($dataGrafik['dataKontrak']) !!}
            }]
        });
    });
    

</script>

