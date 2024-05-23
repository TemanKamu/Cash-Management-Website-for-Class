@extends('dashboard.layout.create')

@section('content-create')
    <div class="card border shadow-sm p-3 mb-5 bg-white rounded" style="margin-top: 100px">

        <h1 class="card-title text-center">Buat kelas</h1>
        <div class="card-body">
            {{-- <p class="card-description"> Basic form layout </p> --}}
            <form class="forms-sample" method="POST" action="{{ route('welcome.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="owner-email-user">Owner room name</label>
                    <input type="email" class="form-control" id="owner-email-user" value="{{ Auth::user()->name }}"
                        readonly>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="nameUser">Nama</label>
                        <input type="text" class="form-control @error('nama_kelas') is-invalid @enderror" id="nameUser"
                            name="nama_kelas" placeholder="Nama kelas">
                        @error('nama_kelas')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-6">
                        <label for="jumlahSiswa">Jumlah maksimal siswa</label>
                        <input type="number" class="form-control @error('jumlah_maksimal_siswa') is-invalid @enderror"
                            id="jumlahSiswa" name="jumlah_maksimal_siswa" placeholder="Jumlah maksimal siswa">
                        @error('jumlah_maksimal_siswa')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="deskripsiKelas">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsiKelas"></textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="profilKelas">Profil kelas</label>
                        <input type="file" class="form-control" id="profilKelas" name="profile_kelas"
                            placeholder="Profil kelas">
                    </div>
                    <div class="form-group col-6">
                        <label for="hargaKas">Harga kas</label>
                        <input type="number" class="form-control" id="hargaKas" name="harga_kas" placeholder="Harga kas">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="payout_password_user">Payout password</label>
                        <input type="password" class="form-control" id="payout_password_user" name="payout_password"
                            placeholder="Masukkan password">
                        <p class="text-muted text-small">Harap diisi karena ini digunakan untuk verifikasi pencairan dana
                            kelas
                        </p>
                    </div>
                </div>

                <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
            </form>
        </div>
    </div>
@endsection
