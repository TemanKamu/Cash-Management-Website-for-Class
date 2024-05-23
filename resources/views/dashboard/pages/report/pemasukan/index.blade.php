@extends('dashboard.layout.index')

@section('content')
    <!-- Modal -->

    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Filter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="card-body p-1">
                        <form action="{{ url('/pemasukan') }}" method="GET">
                            <div class="form-group">
                                <label for="" class="form-label">Name</label>
                                <select name="user" class="form-select">
                                    <option value="all_user" selected>All User</option>
                                    @foreach ($datas->userData as $user)
                                        <option value="{{ $user->uuid }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="kelas_id" value="{{ Auth::user()->kelas_id }}">
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Status</label>
                                <select name="status_pembayaran" class="form-select"
                                    onchange="displayMetodePembayaran(this.value)">
                                    <option value="all_status">Berhasil,Pending & Belum bayar</option>
                                    <option value="sudah bayar">Berhasil</option>
                                    <option value="pending">Pending</option>
                                    <option value="belum bayar">Belum bayar
                                    </option>
                                </select>
                            </div>
                            <div class="forn-group mb-2" id="metodePembayaran">
                                <label for="metode_pemabayran_id">Metode pembayaran</label>
                                <select name="metode_pembayaran" id="metode_pembayaran_id" class="form-select">
                                    <option value="all_metode" id="willSelected">All</option>
                                    <option value="cash">Cash</option>
                                    <option value="transfer">Transfer</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Date at</label>
                                <input type="date" id="date_at_id" name="date_at" class="form-control"
                                    value="{{ isset($_GET['date_at']) ? $_GET['date_at'] : '' }}">
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Date to</label>
                                <input type="date" id="date_to_id" name="date_to" class="form-control"
                                    value="{{ isset($_GET['date_to']) ? $_GET['date_to'] : '' }}">
                            </div>
                            <button class="btn btn-success w-100">Filter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (Auth::user()->isBendahara === 1)
        <div class="modal fade" id="tambahPemasukan" tabindex="-1" aria-labelledby="tambahPemasukanModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahPemasukanModalLabel">Tambah pemasukan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('pemasukan.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="" class="form-label">Name</label>
                                <select name="user_id" id="" class="form-select">
                                    @foreach ($datas->userData as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="kelas_id" value="{{ Auth::user()->kelas_id }}">
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Harga kas total</label>
                                <input type="number" class="form-control bg-light" id="kas_price"
                                    value="{{ $datas->hargaKas }}" readonly>
                                <input type="hidden" class="form-control" id="kas_price_hidden" name="jumlah_pemasukan"
                                    value="{{ $datas->hargaKas }}">
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Date at</label>
                                <input type="date" class="form-control" name="name_date_at" id="date_at" required>
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Date to</label>
                                <input type="date" class="form-control" name="name_date_to" id="date_to" required>
                            </div>
                            <button type="button" class="btn btn-info" onclick="updateKasPrice()">Kalkulasi harga
                                kas</button>
                            <button type="submit" class="btn btn-success disabled" id="submitDisabled">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editPemasukan" tabindex="-1" aria-labelledby="editPemasukanModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPemasukanModalLabel">Edit pemasukan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('pemasukan.updateDate') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="nameUser" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control bg-light" id="nameUser"
                                    readonly>
                                <input type="hidden" name="kelas_id" value="{{ Auth::user()->kelas_id }}">
                                <input type="hidden" name="id" id="pemasukan_id">
                                <input type="hidden" name="uuid" id="user_uuid">
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Date</label>
                                <input type="date" name="date" class="form-control" id="dateUser"
                                    class="form-control">
                            </div>
                            <button type="submit" class="btn btn-info">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
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
            <div class="d-flex justify-content-between align-items-center mb-2">
                @if (Auth::user()->isBendahara === 1)
                    <div>
                        <button class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#filterModal">Filter</button>
                        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#tambahPemasukan">Tambah
                            pemasukan</button>
                    </div>
                @else
                    <div>
                        <button class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#filterModal">Filter</button>
                    </div>
                @endif
                <div class="breadcrumb-item active " data-bs-toggle="tooltip" data-bs-placement="bottom"
                    title="Pemasukan akan selalu di tambahkan setiap pukul 00.00">
                    <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i> <span>Info</span>
                </div>
            </div>
            <div class="table-responsive">
                {{-- <button class="btn btn-primary mb-2">Create new</button> --}}
                <table class="table table-responsive table-borderless" id="table-paginate">
                    <thead>
                        <tr class="bg-light">
                            <th scope="col" width="5%">#</th>
                            <th scope="col" width="20%">Nama</th>
                            <th scope="col" width="20%">Metode pembayaran</th>
                            <th scope="col" width="20%">Status</th>
                            <th scope="col" width="20%">Tanggal </th>
                            <th scope="col" width="20%" class="text-center"> Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->user->name }}</td>
                                <td><i class="fa fa-check-circle-o green"></i><span
                                        class="ms-1">{{ $data->metode_pembayaran === null ? 'Kosong' : $data->metode_pembayaran }}</span>
                                </td>
                                <td><label
                                        class="badge badge-gradient-{{ $data->status === 'belum bayar' ? 'danger' : ($data->status === 'pending' ? 'warning' : 'success') }}">{{ $data->status }}</label>
                                </td>
                                <td>{{ $data->created_at->format('d M, Y') }}</td>
                                <td>
                                    @if (Auth::user()->isBendahara === 1)
                                        @if ($data->status === 'belum bayar' || $data->metode_pembayaran === 'cash')
                                            @if ($data->status === 'belum bayar')
                                                <form action="{{ route('pemasukan.switch', $data->id) }}"
                                                    class="d-inline" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="{{ $data->status }}">
                                                    <input type="hidden" name="kelas_id"
                                                        value="{{ Auth::user()->kelas_id }}">
                                                    <button type="submit"
                                                        class="btn btn-{{ $data->status === 'sudah bayar' ? 'danger' : 'success' }}">
                                                        {{ $data->status === 'sudah bayar' ? 'Belum bayar' : 'Sudah bayar' }}
                                                    </button>
                                                </form>
                                                <form action="{{ route('pemasukan.ingatkanPembayaran', $data->id) }}"
                                                    class="d-inline" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="messager_name"
                                                        value="{{ Auth::user()->name }}">
                                                    <input type="hidden" name="for_user_id"
                                                        value="{{ $data->user_id }}">
                                                    <button type="submit" class="btn btn-primary">Ingatkan bayar</button>
                                                </form>
                                            @else
                                                <button class="btn btn-info" data-bs-toggle="modal"
                                                    data-bs-target="#editPemasukan"
                                                    onclick="editPemasukanUser('{{ $data->user->name }}', '{{ $data->created_at->format('m-d-Y') }}', '{{ $data->id }}', '{{ $data->user->uuid }}' )">Edit
                                                    Tanggal</button>

                                                <form action="{{ route('pemasukan.switch', $data->id) }}"
                                                    class="d-inline" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="{{ $data->status }}">
                                                    <input type="hidden" name="kelas_id"
                                                        value="{{ Auth::user()->kelas_id }}">
                                                    <button type="submit"
                                                        class="btn btn-{{ $data->status === 'sudah bayar' ? 'danger' : 'success' }}">
                                                        {{ $data->status === 'sudah bayar' ? 'Belum bayar' : 'Sudah bayar' }}
                                                    </button>
                                                </form>
                                            @endif
                                        @elseif($data->status === 'sudah bayar' && $data->metode_pembayaran === 'transfer')
                                            <button class="btn btn-secondary disabled">No action</button>
                                        @endif
                                    @else
                                        <button class="btn btn-secondary disabled">No action</button>
                                    @endif
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
        if (document.getElementById("date_at_id").value === "" && document.getElementById("date_to_id").value === "") {
            document.getElementById("date_at_id").valueAsDate = new Date();
            document.getElementById("date_to_id").valueAsDate = new Date();
        }
        document.getElementById("date_at").valueAsDate = new Date();
        document.getElementById("date_to").valueAsDate = new Date();


        function editPemasukanUser(name, date, id, uuid) {
            const nameInput = document.getElementById("nameUser");
            const dateUser = document.getElementById("dateUser");
            const pemasukanUser = document.getElementById("pemasukan_id");
            const userUuid = document.getElementById('user_uuid')
            userUuid.value = uuid
            nameInput.value = name;
            pemasukanUser.value = id;
            dateUser.valueAsDate = new Date(date + 'UTC');
        }

        function displayMetodePembayaran(value) {
            const metodePembayaran = document.getElementById("metodePembayaran");
            if (value === "belum bayar") {
                metodePembayaran.classList.remove("d-block");
                metodePembayaran.classList.add("d-none");
                document.getElementById("willSelected").selected = true;
            } else {
                metodePembayaran.classList.remove("d-none");
                metodePembayaran.classList.add("d-block");
            }
        }

        function getDifferenceInDays(startDate, endDate) {
            const oneDay = 24 * 60 * 60 * 1000;
            const start = new Date(startDate);
            const end = new Date(endDate);
            const differenceInDays = Math.round(Math.abs((start - end) / oneDay));
            return differenceInDays;
        }

        function updateKasPrice() {
            var startDate = document.getElementById("date_at").value;
            var endDate = document.getElementById("date_to").value;

            var kasPrice = parseFloat(document.getElementById("kas_price").value);
            var kasPriceHidden = parseFloat(document.getElementById("kas_price_hidden").value);

            var differenceInDays = getDifferenceInDays(startDate, endDate)
            if (differenceInDays > 0) {
                var hariLibur = 0;
                var effectiveDays = differenceInDays - hariLibur;
                kasPrice = kasPriceHidden * (effectiveDays === 1 ? effectiveDays + 1 : effectiveDays);
            }

            document.getElementById("kas_price").value = Math.round(kasPrice);
            document.getElementById(
                "submitDisabled").classList.remove("disabled");
        }
    </script>
@endsection
