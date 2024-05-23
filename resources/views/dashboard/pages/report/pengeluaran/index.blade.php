@extends('dashboard.layout.index')

@section('content')
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Filter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body p-1">
                        <form action="{{ url('/pengeluaran') }}" method="GET">
                            <input type="hidden" name="kelas_id" value="{{ Auth::user()->kelas_id }}" id="">
                            <div class="form-group">
                                <label for="" class="form-label">Nama</label>
                                <select name="user" class="form-select">
                                    <option value="all_user" selected>All User</option>
                                    @foreach ($datas->userData as $item)
                                        <option value="{{ $item->uuid }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Metode pengeluaran</label>
                                <select name="jenis_pengeluaran" id="" class="form-select">
                                    <option value="all_metode" selected>All Metode</option>
                                    <option value="cash">Cash</option>
                                    <option value="transfer">Transfer</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Status</label>
                                <select name="status" id="" class="form-select">
                                    {{-- <option selected disabled>Status penarikan</option> --}}
                                    <option value="berhasil">Berhasil</option>
                                    <option value="pending">Pending</option>
                                    <option value="gagal">Gagal</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Date at</label>
                                <input type="date" name="date_at" id="date_at_id"
                                    value="{{ isset($_GET['date_to']) ? $_GET['date_at'] : '' }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Date to</label>
                                <input type="date" name="date_to" id="date_to_id"
                                    value="{{ isset($_GET['date_to']) ? $_GET['date_to'] : '' }}" class="form-control">
                            </div>
                            <button class="btn btn-success w-100">Filter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add pengeluaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body p-1">
                        <form action="{{ route('pengeluaran.store') }}" method="POST">
                            @csrf
                            <input type="text" name="user" value="{{ Auth::user()->uuid }}" hidden>
                            <input type="text" name="kelas_id" value="{{ Auth::user()->kelas_id }}" hidden>
                            <div class="form-group">
                                <label for="" class="form-label">Jumlah</label>
                                <input type="number" class="form-control" placeholder="Masukkan jumlah pengeluaran"
                                    name="jumlah_pengeluaran">
                            </div>
                            {{-- <div class="form-group">
                                    <label for="" class="form-label">Urutkan</label>
                                    <select name="" id="" class="form-select">
                                        <option selected disabled>Urutkan tanggal</option>
                                        <option value="">Terbaru -> Terlama</option>
                                        <option value="">Terlama -> Terbaru</option>
                                        <option value="">Sekarang</option>
                                    </select>
                                </div> --}}
                            <div class="form-group">
                                <label for="" class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" cols="30" rows="10"
                                    placeholder="Masukkan deskripsi pengeluaran"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Date</label>
                                <input type="date" id="date_at" name="date" class="form-control">
                            </div>
                            <button class="btn btn-success w-100">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editPemasukan" tabindex="-1" aria-labelledby="editPemasukanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPemasukanModalLabel">Edit pengeluaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="editPemasukanForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="kelas_id" value="{{ Auth::user()->kelas_id }}">
                        <input type="hidden" name="id" id="pengeluaran_id">
                        <div class="form-group">
                            <label for="jumlah_id" class="form-label">Jumlah</label>
                            <input type="text" name="jumlah_pengeluaran" class="form-control bg-light"
                                id="jumlah_id">
                        </div>
                        <div class="form-group">
                            <label for="deskripsi_id" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" name="deskripsi" class="form-control" id="deskripsi_id" cols="30" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Date</label>
                            <input type="date" name="date" class="form-control" id="date_id"
                                class="form-control">
                        </div>
                        <button type="submit" class="btn btn-info">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row w-100 mx-auto">
        <div class="col-sm-12 col-xl-12">
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

            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#filterModal">Filter</button>
                    <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah
                        pengeluaran</button>
                </div>
                {{-- <div class="breadcrumb-item active " data-bs-toggle="tooltip" data-bs-placement="bottom"
                    title="Pemasukan akan selalu di tambahkan setiap pukul 00.00">
                    <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i> <span>Info</span>
                </div> --}}
            </div>
            <div class="table-responsive">
                <table class="table table-responsive table-borderless" id="table-paginate">
                    <thead>
                        <tr class="bg-light">
                            <th scope="col" width="5%">#</th>
                            <th scope="col" width="20%">Nama</th>
                            <th scope="col" width="20%">Jumlah</th>
                            <th scope="col" width="20%">Metode penarikan</th>
                            <th scope="col" width="20%">Status</th>
                            <th scope="col" width="20%">Deskripsi</th>
                            <th scope="col" width="20%">Tanggal </th>
                            <th scope="col" class="text-center" width="20%"> Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->user->name }}</td>
                                <td>Rp {{ number_format($data->jumlah_pengeluaran) }}</td>
                                <td>{{ $data->jenis_pengeluaran }}</td>
                                <td><label
                                        class="badge badge-gradient-{{ $data->status === 'berhasil' ? 'success' : ($data->status === 'pending' ? 'warning' : 'danger') }}">
                                        {{ $data->status }} </label></td>
                                <td>{{ $data->deskripsi }}</td>
                                <td>{{ $data->created_at->format('d M, Y') }}</td>
                                <td>
                                    <button
                                        class="btn btn-info {{ $data->jenis_pengeluaran === 'cash' ? '' : 'disabled' }}"
                                        data-bs-toggle="modal" data-bs-target="#editPemasukan"
                                        onclick="editPengeluaranUser('{{ $data->jumlah_pengeluaran }}', '{{ $data->deskripsi }}', '{{ $data->created_at->format('m-d-Y') }}', '{{ $data->id }}' )">Edit</button>
                                    <form action="{{ route('pengeluaran.destroy', $data->id) }}" class="d-inline"
                                        method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit"
                                            class="btn btn-danger {{ $data->jenis_pengeluaran === 'cash' ? '' : 'disabled' }}">Delete</button>
                                    </form>
                                </td>
                                {{-- <td class="text-end"><span class="fw-bolder">$0.99</span> <i class="fa fa-ellipsis-h  ms-2"></i>
                        </td> --}}
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
        document.getElementById("date_at").valueAsDate = new Date();
        if (document.getElementById("date_at_id").value === "" && document.getElementById("date_to_id").value === "") {
            document.getElementById("date_at_id").valueAsDate = new Date();
            document.getElementById("date_to_id").valueAsDate = new Date();
        }

        function editPengeluaranUser(jumlah, deskripsi, tanggal, id) {
            document.getElementById("jumlah_id").value = jumlah;
            document.getElementById("deskripsi_id").value = deskripsi;
            document.getElementById("date_id").valueAsDate = new Date(tanggal + "UTC");
            document.getElementById("pengeluaran_id").value = id;

            document.getElementById('editPemasukanForm').action = "{{ route('pengeluaran.update', ':id') }}".replace(':id',
                id);
        }
    </script>
@endsection
