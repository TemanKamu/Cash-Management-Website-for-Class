@extends('dashboard.layout.index')

@section('content')
    <section id="edit" class="m-2 d-flex justify-content-center flex-wrap w-100 ">
        <section id="avatar-kelas" class="me-3 col-xl-4 col-sm-10" style="height: 300px">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="text-center">{{ $data['nama_kelas'] }}</h3>
                    <p class="text-center">
                        Owner: <b>{{ $data->owner_name }}</b>
                    </p>
                    <div class="text-center mt-4">
                        <img src="{{ Storage::url($data->profile_kelas) }}" class="img-fluid rounded-circle w-50 "
                            alt="image" style="border: 0.5px solid black">

                    </div>
                    <form action="{{ route('profile.update') }}" class="text-center mt-4" id="uploadForm"
                        enctype="multipart/form-data" method="POST">
                        @csrf
                        <input type="hidden" name="kelas_id" value="{{ Auth::user()->kelas_id }}">
                        <input type="file" id="photoInput" name="profile_kelas" style="display: none;">
                        <button type="button" class="btn btn-gradient-danger btn-icon-text" id="choosePhotoButton">
                            <i class="mdi mdi-upload btn-icon-prepend"></i> Upload new photo </button>
                    </form>
                    {{-- <div class="card border text-center">
                        <p class="text-center ">
                            Maximum upload size is <span class="fw-bold">1 MB</span>
                        </p>
                    </div> --}}
                    <div class="text-center mt-3">
                        Room created at: <b>{{ $data->created_at->format('d F Y') }}</b>
                    </div>
                </div>
            </div>
        </section>
        <section id="form-edit" class="col-xl-7 col-sm-12">
            <div class="card shadow">
                <div class="card-header">
                    <h3 class="m-2">Edit profile</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Kode Kelas</label>
                        <input type="text" class="form-control" value="{{ $data->kode_kelas }}" readonly>
                        <a href="{{ route('resetKodeKelas', $data->kode_kelas) }}" class="text-dark"><small>Atur ulang
                                kode</small></a>
                    </div>
                    <form action="{{ route('manage-class.update', $data->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Nama Kelas</label>
                                    <input type="text" class="form-control l @error('nama_kelas') is-invalid @enderror"
                                        name="nama_kelas" value="{{ $data->nama_kelas }}">
                                    @error('nama_kelas')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Jumlah maksimal siswa</label>
                                    <input type="number"
                                        class="form-control @error('jumlah_maksimal_siswa') is-invalid @enderror"
                                        name="jumlah_maksimal_siswa" value="{{ $data->jumlah_maksimal_siswa }}">
                                    @error('jumlah_maksimal_siswa')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Harga kas</label>
                                    <input type="number" class="form-control @error('harga_kas') is-invalid @enderror"
                                        name="harga_kas" value="{{ $data->harga_kas }}">
                                    @error('harga_kas')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Deskripsi kelas</label>
                                    <textarea name="deskripsi" id="" cols="30" rows="10"
                                        class="form-control @error('deskripsi') is-invalid @enderror">{{ $data->deskripsi }}</textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-gradient-dark btn-icon-text"> Edit <i
                                class="mdi mdi-file-check btn-icon-append"></i>
                        </button>
                    </form>
                </div>
            </div>

        </section>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let choosePhotoButton = document.getElementById('choosePhotoButton');
            let photoInput = document.getElementById('photoInput');

            choosePhotoButton.addEventListener('click', function() {
                photoInput.click();
            });

            photoInput.addEventListener('change', function() {
                const form = document.getElementById('uploadForm');
                form.submit();
            });
        });
    </script>
@endsection
