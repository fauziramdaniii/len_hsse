@extends('layouts.main')
@section('sidebar')
    @if (Auth::User()->role == 'supervisor')
        <li class="nav-item {{ Request::is('apar/dashboard') ? 'active' : '' }}">
            <a class="nav-link " href="/apar/dashboard">
                <i class="mdi mdi-view-dashboard menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('apar/dataapar*') ? 'active' : '' }}">
            <a class="nav-link" href="/apar/dataapar">
                <i class="mdi mdi-fire-extinguisher menu-icon"></i>
                <span class="menu-title">Master APAR</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('apar/masterinspeksi*') ? 'active' : '' }}">
            <a class="nav-link" href="/apar/masterinspeksi">
                <i class="mdi mdi-calendar-clock menu-icon"></i>
                <span class="menu-title">Master Inspeksi</span>
            </a>
        </li>

        <li class="nav-item {{ Request::is('apar/inspeksi*') ? 'active' : '' }}">
            <a class="nav-link" href="/apar/inspeksi">
                <i class="mdi mdi-clipboard-text menu-icon"></i>
                <span class="menu-title">Inspeksi APAR</span>
            </a>
        </li>
    @else
        <li class="nav-item  {{ Request::is('dashboard*') ? 'active' : '' }}">
            <a class="nav-link" href="/dashboard">
                <i class="mdi mdi-view-dashboard menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('apar/inspeksi*') ? 'active' : '' }}">
            <a class="nav-link" href="/apar/inspeksi">
                <i class="mdi mdi-clipboard-text menu-icon"></i>
                <span class="menu-title">Inspeksi APAR</span>
            </a>
        </li>
    @endif
@endsection
<?php $no = 1; ?>
@section('content')
    @include('sweetalert::alert')
    <br>
    <h3 class="font-weight-bold text-center">
        Data Inspeksi APAR (Periode {{ date('F Y', strtotime($aparinspeksi->periode)) }})
    </h3>
    <div class="col-sm-12">
        <br>
        @if (session()->get('success'))
            <div class="alert alert-sucess">
                {{ session()->get('sucess') }}
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card card-tale">
                <div class="card-body text-center">
                    <h4 class="card-title text-light">{{ $verifiedInspection }}</h4>
                    <div class="media">
                        <div class="media-body">
                            <p class="card-text">Inspeksi sudah diverifikasi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card card-dark-blue">
                <div class="card-body text-center">
                    <h4 class="card-title text-light">{{ $waitingInspection }}</h4>
                    <div class="media">
                        <div class="media-body">
                            <p class="card-text">Menunggu Verifikasi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card card-light-blue">
                <div class="card-body text-center">
                    <h4 class="card-title text-light">{{ $notInspected }}</h4>
                    <div class="media">
                        <div class="media-body">
                            <p class="card-text">APAR yang belum diinspeksi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card card-light-danger">
                <div class="card-body text-center">
                    <h4 class="card-title text-light">{{ $reInspection }}</h4>
                    <div class="media">
                        <div class="media-body">
                            <p class="card-text">APAR yang perlu inspeksi ulang</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <a href="/apar/inspeksi/{{ $aparinspeksi->id }}/inputInpeksiApar" class="btn btn-info btn-md my-2"
                style="float:right">Input Inspeksi</a>
        </div>

    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <div class="card">
                    <div class="card-body">

                        <table class="display expandable-table dataTable no-footer mb-2" id="order-listing" width="100%">
                            <thead>
                                <tr class="text-center">
                                    <th> No </th>
                                    <th> Kode </th>
                                    <th> Tipe </th>
                                    <th> Jenis </th>
                                    <th> Lokasi </th>
                                    <th> Gedung </th>
                                    <th> Lantai </th>
                                    <th> Titik </th>
                                    <th> Status </th>
                                </tr>

                            </thead>
                            <tbody>
                                @foreach ($aparinspeksi->DetailInspeksi as $dataapar)
                                    <tr class="text-center">
                                        <td> {{ $no++ }} </td>
                                        <td> {{ $dataapar->Apart->kd_apar }} </td>
                                        <td> {{ $dataapar->Apart->Tipe->nama_tipe }} </td>
                                        <td> {{ $dataapar->Apart->Jenis->nama_jenis }} </td>
                                        <td> {{ $dataapar->Apart->lokasi }} </td>
                                        <td> {{ $dataapar->Apart->gedung }} </td>
                                        <td> {{ $dataapar->Apart->lantai }} </td>
                                        <td> {{ $dataapar->Apart->titik }} </td>
                                        <td>
                                            @if ($dataapar->jenis == null)
                                                <a href="/apar/inspeksi/{{ $aparinspeksi->id }}/inputInpeksiApar"
                                                    class="btn btn-dark btn-sm my-2 p-2">Belum Inspeksi </a>
                                            @else
                                                @if ($dataapar->status == 'Belum Verifikasi')
                                                    <button type="button" class="btn btn-info  btn-sm my-2 p-2 lihatHasil"
                                                        href="#" data-toggle="modal" data-target="#modalHasil"
                                                        data-id="{{ $dataapar->id }}">
                                                        @if (auth()->user()->role == 'supervisor')
                                                            Periksa Data
                                                        @elseif(auth()->user()->role == 'petugasapar')
                                                            Menunggu Verifikasi
                                                        @endif
                                                    </button>
                                                @elseif ($dataapar->status == 'Gagal Verifikasi')
                                                    <a href="/apar/inspeksi/{{ $dataapar->id }}/editInspeksi"
                                                        class="btn btn-warning btn-sm my-2 p-2">Inspeksi Ulang </a>
                                                @elseif ($dataapar->status == 'Sudah Verifikasi')
                                                    <button type="button"
                                                        class="btn btn-success  btn-sm my-2 p-2 lihatHasil" href="#"
                                                        data-toggle="modal" data-target="#modalHasil"
                                                        data-id="{{ $dataapar->id }}"> Sudah Verifikasi </button>
                                                @endif
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modal')
    <div class="modal fade" id="modalHasil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hasil Inspeksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="font-weight-bold">Kode APAR : <span id="kdApar"></span></p>
                    <p class="font-weight-bold">Tanggal Inspeksi : <span id="tanggal"></span></p>
                    <table class=" table table-bordered" style="width: 100%">
                        <tbody>
                            <tr class="">
                                <td class="font-weight-bold"><b>PRESSURE/CATRIDGE</b> </td>
                                <td> <span id="pressure"></span></td>
                            </tr>
                            <tr class="">
                                <td class="font-weight-bold"><b>NOZZLE</b></td>
                                <td> <span id="nozzle"></span></td>
                            </tr>
                            <tr class="">
                                <td class="font-weight-bold">SELANG</td>
                                <td> <span id="selang"></span></td>
                            </tr>
                            <tr class="">
                                <td class="font-weight-bold">TABUNG</td>
                                <td> <span id="tabung"></span></td>
                            </tr>
                            <tr class="">
                                <td class="font-weight-bold">RAMBU</td>
                                <td> <span id="rambu"></span></td>
                            </tr>
                            <tr class="">
                                <td class="font-weight-bold">LABEL</td>
                                <td> <span id="label"></span></td>
                            </tr>
                            <tr class="">
                                <td class="font-weight-bold">KONDISI CAT</td>
                                <td> <span id="cat"></span></td>
                            </tr>
                            <tr class="">
                                <td class="font-weight-bold">SAFETY PIN</td>
                                <td> <span id="pin"></span></td>
                            </tr>
                            <tr class="">
                                <td class="font-weight-bold">RODA</td>
                                <td> <span id="roda"></span></td>
                            </tr>
                            <tr class="">
                                <td class="font-weight-bold">KETERANGAN </td>
                                <td> <span id="keterangan"></span></td>
                            </tr>
                            <tr class="">
                                <td class="font-weight-bold">Status </td>
                                <td> <span id="status"></span></td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="mt-3 font-weight-bold">Bukti Foto :</p>
                    <img id="buktiFoto" class="fotoBukti" alt="">
                </div>
                <div class="modal-footer">
                    @if (auth()->user()->role == 'supervisor')
                        <form action="/apar/inspeksi/verifikasi" method="post" id="verification-success">
                            @csrf
                            <input type="hidden" name="id" id="detail_id">
                            <input type="hidden" name="status" value="Sudah Verifikasi">
                            <input type="submit" class="btn btn-success" value="Verifikasi">
                        </form>
                        <form action="/apar/inspeksi/verifikasi" method="post" id="verification-failed">
                            @csrf
                            <input type="hidden" name="id" id="detail_gagal_id">
                            <input type="hidden" name="status" value="Gagal Verifikasi">
                            <input type="submit" class="btn btn-danger" value="Gagal Verifikasi">
                        </form>
                    @endif
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        var flagsUrl = "{{ URL::asset('/foto_inspeksi_apar') }}";

        $('.lihatHasil').on('click', function() {
            var id = $(this).attr('data-id');
            $.get('/apar/hasilInspeksi/' + id, function(data) {
                $('#pressure').text(data.data.jenis);
                $('#nozzle').text(data.data.noozle);
                $('#selang').text(data.data.selang);
                $('#tabung').text(data.data.tabung);
                $('#rambu').text(data.data.rambu);
                $('#label').text(data.data.label);
                $('#cat').text(data.data.cat);
                $('#pin').text(data.data.pin);
                $('#roda').text(data.data.roda);
                $('#keterangan').text(data.data.keterangan);
                $('#tanggal').text(data.data.tanggal);
                $('#kdApar').text(data.apar.id);
                $("#buktiFoto").attr("src", flagsUrl + "/" + data.data.foto);
                $('#status').text(data.data.status);
                $('#detail_id').val(data.data.id);
                $('#detail_gagal_id').val(data.data.id);
                if (data.data.status == "Belum Verifikasi") {
                    $('#verification-success').show();
                    $('#verification-failed').show();
                } else {
                    $('#verification-success').hide();
                    $('#verification-failed').hide();
                }
            });
        });

        $('#order-listing').DataTable();
    </script>
@endsection
