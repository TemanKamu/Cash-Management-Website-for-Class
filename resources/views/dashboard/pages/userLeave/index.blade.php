@extends('dashboard.layout.index')

@section('content')
    <div class="modal fade" id="alasanTidakDiizinkan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="" method="POST" id="myForm">
                        @csrf
                        <input type="hidden" name="bendaharaName" value="{{ Auth::user()->name }}">
                        <div class="form-group">
                            <label for="">Masukkan alasan</label>
                            <input type="text" name="alasan" class="form-control" id="alasan">
                        </div>
                        <div class="d-flex">
                            <button type="button" class="btn btn-secondary w-50 me-3"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger w-50">Ya</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="izinkan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h2 class="text-center">Apakah anda yakin ingin mengeluarkan siswa <span id="name"></span> kelas
                        ini ?</h2>
                    <form action="" method="POST" id="izinkanKeluar">
                        @csrf
                        @method('DELETE')
                      
                        <div class="d-flex">
                            <button type="button" class="btn btn-secondary w-50 me-3"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger w-50">Ya</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row w-100 mx-auto">
        <div class="flex-wrap col-sm-12 col-xl-12">
            @if (session()->has('failed'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ session('failed') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @elseif(session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="table-responsive">
                {{-- <button class="btn btn-primary mb-2">Create new</button> --}}
                <table class="table table-responsive table-borderless" id="table-paginate">
                    <thead>
                        <tr class="bg-light">
                            <th scope="col" width="5%"> # </th>
                            <th scope="col" width="20%"> Nama </th>
                            <th scope="col" width="20%"> Email </th>
                            <th scope="col" width="20%"> Alasan </th>
                            <th scope="col" width="20%" class="text-center"> Aksi </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $item)
                            <tr>
                                <td> {{ $loop->iteration }} </td>
                                <td> {{ $item->user->name }} </td>
                                <td>
                                    {{ $item->user->email }}
                                </td>
                                <td>
                                    {{ $item->description }}
                                </td>
                                <td>
                                    <button class="btn btn-info" data-bs-toggle="modal"
                                        data-bs-target="#alasanTidakDiizinkan"
                                        onclick="changeAction({{ $item->id }})">jangan izinkan</button>
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#izinkan"
                                        onclick="changeActionIzinkan({{ $item->id }})">Izinkan</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <script src="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-2.0.3/datatables.min.js"></script>
    <script>
        $('#table-paginate').DataTable()
    </script>
    <script>
        // Mengambil elemen form
        var form = document.getElementById('myForm');
        var formIzinkan = document.getElementById('izinkanKeluar');

        function changeActionIzinkan(id) {
            formIzinkan.action = `{{ route('keluar.destroy', '') }}/${id}`;

        }
        // Mengubah action form
        function changeAction(id) {
            form.action = `{{ route('keluar.notAllowed', '') }}/${id}`;
        }
    </script>
@endsection
