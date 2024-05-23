@extends('dashboard.layout.index')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh">
        @if (session()->has('success'))
            <div class="card mb-3" style="border-radius: .5rem;">
                <div class="row g-0">
                    <div class="col-md-4 text-center text-white bg-primary"
                        style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem; border-bottom-left-radius: .5rem; ">
                        <img src="{{ Storage::url(session('datas')->profile_kelas) }}" alt="Avatar" class="img-fluid my-5"
                            style="width: 80px; border-radius: 50%;" />
                        <h5 class="w-75 text-center mx-auto">{{ session('datas')->nama_kelas }}</h5>
                        <i class="far fa-edit mb-5"></i>
                        <div class="d-flex justify-content-center mb-2">
                            <a href="#!"><i class="mdi mdi-facebook mdi-24px text-white me-2"></i></a>
                            <a href="#!"><i class="mdi mdi-twitter mdi-24px text-white me-2"></i></a>
                            <a href="#!"><i class="mdi mdi-instagram mdi-24px text-white"></i></a>
                        </div>

                    </div>
                    <div class="col-md-8 border border-dark"
                        style="border-bottom-right-radius: .5rem; border-top-right-radius: .5rem;">
                        <div class="card-body p-4">
                            <h6>Information</h6>
                            <hr class="mt-0 mb-4">
                            <div class="row pt-1">
                                <div class="col-9 mb-3">
                                    <h6>Description</h6>
                                    <p class="text-muted">{{ session('datas')->deskripsi }}</p>
                                </div>
                                {{-- <div class="col-6 mb-3">
                                <h6>Phone</h6>
                                <p class="text-muted">123 456 789</p>
                            </div> --}}
                            </div>
                            <h6>Detail</h6>
                            <hr class="mt-0 mb-4">
                            <div class="row pt-1">
                                <div class="col-6 mb-3">
                                    <h6>Owner room</h6>
                                    <p class="text-muted">{{ session('datas')->owner_room_name }}</p>
                                </div>
                                <div class="col-6 mb-3">
                                    <h6>Harga kas</h6>
                                    <p class="text-muted">Rp, {{ number_format(session('datas')->harga_kas) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="m-3 d-flex">
                            <form action="{{ route('welcome.join', session('datas')->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" hidden>
                                <button type="submit" class="btn btn-gradient-primary me-2">Join</button>
                            </form>
                            <button class="btn btn-light" onclick="location.reload()">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="card border shadow-sm p-3 mb-5 bg-white rounded">
                <div class="card-body">
                    @if (session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ session('error') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @elseif(session()->has('error_internal'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ session('error_internal') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <h5 class="card-title text-center">Masukkan nomor unik kelas</h5>
                    <form class="mb-3" method="GET" action="{{ url('/welcome/join') }}">
                        <input type="text" class="form-control" placeholder="Search..." name="search" required>
                        <div class="text-left mt-3">
                            <button class="btn w-100 btn-primary" type="submit">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>


@endsection
