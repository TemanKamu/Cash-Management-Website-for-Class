@extends('dashboard.layout.index')

@section('content')
    <section id="edit" class="m-2 d-flex justify-content-center flex-wrap w-100 ">
        <section id="avatar-kelas" class="me-3 col-xl-4 col-sm-10" style="height: 300px">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="text-center">{{ $data->name }}</h3>

                    <div class="text-center mt-4">
                        <img src="{{ $data->profile_user !== null ? Storage::url($data->profile_user) : asset('dashboard/assets/images/faces/face1.jpg') }}"
                            class="img-fluid rounded-circle w-50 " alt="image" style="border: 0.5px solid black">

                    </div>
                    <form action="{{ route('setting-user.editProfile') }}" class="text-center mt-4" id="uploadForm"
                        enctype="multipart/form-data" method="POST">
                        @csrf
                        <input type="file" id="photoInput" name="profile_user" style="display: none;">
                        <input type="hidden" name="user_id" value="{{ $data->id }}" style="display: none;">
                        <button type="button" class="btn btn-gradient-danger btn-icon-text" id="choosePhotoButton">
                            <i class="mdi mdi-upload btn-icon-prepend"></i> Upload new photo </button>
                    </form>
                    {{-- <div class="card border text-center">
                        <p class="text-center ">
                            Maximum upload size is <span class="fw-bold">1 MB</span>
                        </p>
                    </div> --}}
                    <div class="text-center mt-3">
                        Account created at: <b>{{ $data->created_at->format('d F Y') }}</b>
                    </div>
                </div>
            </div>
        </section>
        <section id="form-edit" class="col-xl-7 col-sm-12">
            <div class="card shadow">
                <div class="card-header">
                    <h3 class="m-2">Edit profile </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('setting-user.update', $data->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Nama</label>
                                    <input type="text" class="form-control l @error('name') is-invalid @enderror"
                                        name="name" value="{{ $data->name }}">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ $data->email }}">
                                    @error('email')
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
                                    <label for="">No hp</label>
                                    <input type="number" class="form-control @error('no_hp') is-invalid @enderror"
                                        name="no_hp" value="{{ $data->no_hp }}">
                                    @error('no_hp')
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
