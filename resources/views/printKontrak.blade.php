<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    @foreach($pasalKJaminan as $pasal1)
    @if($pasal1->jenis_pasal == '1')
    <div class="row">
        <div class="card">
            {{ $pasal1->nama_pasal }} <br>
            {{ $pasal1->keterangan_pasal }} <br>
            {{ $pasal1->isi_pasal }} <br>
            <hr>
        </div>
    </div>
    @elseif($pasal1->jenis_pasal == '2')
    <div class="row">
        <div class="card">
            {{ $pasal1->nama_pasal }} <br>
            {{ $pasal1->keterangan_pasal }} <br>
            {{ $pasal1->isi_pasal }} <br>
            <hr>
        </div>
    </div>
    @endif
    @endforeach
</body>


</html>