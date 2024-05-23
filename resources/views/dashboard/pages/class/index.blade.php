@extends('dashboard.layout.index')
@section('content')
 
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title">
                    <span class="page-title-icon bg-gradient-primary text-white me-2">
                        <i class="mdi mdi-home"></i>
                    </span> Dashboard
                </h3>
                <nav aria-label="breadcrumb">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">
                            <span></span>Overview <i
                                class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="row">
                <div class="col-md-3 stretch-card grid-margin">
                    <div class="card bg-gradient-danger card-img-holder text-white">
                        <div class="card-body">
                            <img src="{{ asset('dashboard/assets/images/dashboard/circle.svg') }}" class="card-img-absolute"
                                alt="circle-image" />
                            <h4 class="font-weight-normal mb-3">Saldo digital<i
                                    class="mdi mdi-chart-line mdi-24px float-right"></i>
                            </h4>
                            <h2 class="mb-5">Rp {{ number_format($datas['saldo_digital']) }}</h2>
                            <h6 class="card-text"><a class="text-white" href="/pemasukan">Detail</a></h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 stretch-card grid-margin">
                    <div class="card bg-gradient-danger card-img-holder text-white">
                        <div class="card-body">
                            <img src="{{ asset('dashboard/assets/images/dashboard/circle.svg') }}" class="card-img-absolute"
                                alt="circle-image" />
                            <h4 class="font-weight-normal mb-3">Cash<i class="mdi mdi-chart-line mdi-24px float-right"></i>
                            </h4>
                            <h2 class="mb-5">Rp {{ number_format($datas['saldo_fisik']) }}</h2>
                            <h6 class="card-text"><a class="text-white" href="/pemasukan">Detail</a></h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 stretch-card grid-margin">
                    <div class="card bg-danger card-img-holder text-white">
                        <div class="card-body">
                            <img src="{{ asset('dashboard/assets/images/dashboard/circle.svg') }}" class="card-img-absolute"
                                alt="circle-image" />
                            <h4 class="font-weight-normal mb-3">Pengeluaran<i
                                    class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                            </h4>
                            <h2 class="mb-5">Rp {{ number_format($datas['jumlah_pengeluaran']) }}</h2>
                            <h6 class="card-text"><a class="text-white" href="/pengeluaran">Detail</a></h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 stretch-card grid-margin">
                    <div class="card bg-gradient-success card-img-holder text-white">
                        <div class="card-body">
                            <img src="{{ asset('dashboard/assets/images/dashboard/circle.svg') }}" class="card-img-absolute"
                                alt="circle-image" />
                            <h4 class="font-weight-normal mb-3"> Student <i
                                    class="mdi mdi-account mdi-24px float-right"></i>
                            </h4>
                            <h2 class="mb-5">{{ $datas['jumlah_siswa'] }} / {{ $datas['jumlah_maksimal_siswa'] }}</h2>
                            <h6 class="card-text"><a class="text-white" href="/manage-user">Detail</a></h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-7 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="clearfix">
                                <h4 class="card-title float-left">Chart Bar</h4>
                                <div id="visit-sale-chart-legend"
                                    class="rounded-legend legend-horizontal legend-top-right float-right">
                                </div>
                            </div>
                            <canvas id="visit-sale-chart" class="mt-4"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Money flow</h4>
                            <canvas id="traffic-chart"></canvas>
                            <div id="traffic-chart-legend" class="rounded-legend legend-vertical legend-bottom-left pt-4">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Data Pemasukan sekarang</h4>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th> Siswa </th>
                                            <th> Via pembayaran </th>
                                            <th> Status </th>
                                            <th> Tanggal </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datas['riwayat_pemasukan'] as $item)
                                            <tr>
                                                <td>

                                                    <img src="{{ $item->user->profile_user ? Storage::url($item->user->profile_user) : asset('dashboard/assets/images/faces/face1.jpg') }}"
                                                        class="me-2" alt="image">
                                                    {{ $item->user->name }}
                                                </td>
                                                <td> {{ $item->metode_pembayaran }} </td>
                                                <td>
                                                    <label
                                                        class="badge badge-gradient-success">{{ $item->status }}</label>
                                                </td>
                                                <td> {{ $item->created_at }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
