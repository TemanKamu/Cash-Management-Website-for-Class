@extends('dashboard.layout.index')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh">
        <div class="card border shadow-sm p-3 mb-5 bg-white rounded">
            {{-- <h5 class="card-header">Featured</h5> --}}
            <div class="card-body">
                <h5 class="card-title text-center">Selamat datang di dashboard {{ Auth::user()->name }}! </h5>
                <p class="card-text text-center">Nampaknya kamu belum memiliki kelas! Apakah kamu ingin Bergabung atau
                    membuat
                    kelas ?</p>
                <div class="text-center">
                    <a class="btn btn-primary me-4" href="welcome/join"><i class="mdi mdi-login-variant"></i>Gabung
                        kelas</button>
                        <a class="btn btn-primary" href="{{ route('welcome.create') }}"><i class="mdi mdi-plus"></i>Buat
                            kelas</a>
                </div>
            </div>
        </div>
    </div>
@endsection
