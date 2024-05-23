<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Kelas-ku</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('dashboard/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('dashboard/assets/images/logo/logo.jpg') }}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-2.0.3/datatables.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
</head>

<body>
    <div class="container-scroller">
        {{-- @dd($pemasukanData->metode_pembayaran) --}}
        @include('dashboard.partials.navbar')
        <div class="container-fluid page-body-wrapper">
            @if (Auth::user()->kelas_id !== null && Auth::user()->status_verifikasi_kelas === 1)
                <div class="modal fade" id="userKeluar" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <h2 class="text-center">Apakah anda yakin ingin keluar kelas ini ?</h2>
                                <form action="{{ route('keluar.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                    <input type="hidden" name="kelas_id" value="{{ Auth::user()->kelas_id }}">
                                    <div class="form-group">
                                        <label for="">Masukkan alasan</label>
                                        <input type="text" name="description" class="form-control" id="alasan">
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
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content ">
                            <div class="modal-body">
                                <header class="mb-3">
                                    <h1 class="modal-title fs-5 text-center">Payment receipt</h1>
                                </header>
                                <article class='m-5'>
                                    <header>
                                        <p class="m-1">
                                            <small>{{ Auth::user()->name }}</small>
                                        </p>
                                        <p class="m-1">
                                            <small>{{ Carbon\Carbon::now()->toFormattedDateString() }}</small>
                                        </p>
                                        <p class="m-1">
                                            <small
                                                class="{{ $pemasukanData === null ? 'text-danger' : 'text-success' }}">{{ $pemasukanData === null ? 'Belum bayar' : 'Sudah bayar' }}</small>
                                        </p>
                                    </header>
                                    <article>
                                        <hr>
                                        <p class="d-flex justify-content-between m-1">
                                            <small>Bayar kas pada tanggal
                                                {{ Carbon\Carbon::now()->toFormattedDateString() }}</small>
                                            <small>Rp
                                                {{ number_format(App\Models\ClassTable::find(Auth::user()->kelas_id)->harga_kas) }}</small>
                                        </p>
                                    </article>
                                    <footer style="margin-top: 50px">
                                        <hr class="border-black border-5">
                                        <div class="d-flex justify-content-between">
                                            <small class="fw-bold">Total</small>
                                            <small>Rp
                                                {{ number_format(App\Models\ClassTable::find(Auth::user()->kelas_id)->harga_kas) }}</small>
                                        </div>
                                        <hr class="border-black border-5">
                                    </footer>
                                </article>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button"
                                    class="btn btn-primary {{ $pemasukanData !== null ? 'disabled' : '' }}"
                                    id="handlePayment">Bayar
                                    sekarang</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="penarikan" tabindex="-1" aria-labelledby="penarikanModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content ">
                            <div class="modal-body">
                                <div class="card bg-gradient-danger text-white" style="height: 7rem;">
                                    <div class="card-body">
                                        <h2 class="mb-5 text-center">Saldo digital:
                                            {{ number_format(App\Models\ClassTable::find(Auth::user()->kelas_id)->saldo_digital) }}
                                        </h2>
                                    </div>
                                </div>
                                <form action="{{ route('payout.detail') }}" class="mt-2" method="POST">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                    <input type="hidden" name="kelas_id" value="{{ Auth::user()->kelas_id }}">
                                    <div class="form-group">
                                        <label for="" class="form-label">Metode penarikan</label>
                                        <select name="channel_code" id="" class="form-select">
                                            <option value="ID_BCA">BCA</option>
                                            <option value="ID_MANDIRI">MANDIRI</option>
                                            <option value="ID_GOPAY">GOPAY</option>
                                            <option value="ID_DANA">DANA</option>
                                            <option value="ID_OVO">OVO</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Nomor rekening / Hadnphone(Jika Metode penarikan
                                            E-Wallet)</label>
                                        <input type="text" class="form-control"
                                            placeholder="Masukkan nomor rekening / hadnphone" name="account_number">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Nama pemilik rekening / E-wallet</label>
                                        <input type="text" class="form-control"
                                            placeholder="Masukkan nama pemilik rekening / E-wallet"
                                            name="account_name">
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="form-label">Jumlah</label>
                                        <input type="text" class="form-control text-dark"
                                            placeholder="Masukkan jumlah penarikan" name="amount">
                                        <small class="text-danger {{ session('nominal') === true ? 'd-block' : 'd-none' }}">* Saldo kurang</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="form-label">Deskripsi pengeluaran</label>
                                        <input type="text" class="form-control text-dark"
                                            placeholder="Masukkan deskripsi" name="description">
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="form-label">Payout password</label>
                                        <input type="password" class="form-control" placeholder="Masukkan password"
                                            name="payout_password">
                                        <small class="text-danger {{ session('password') === true ? 'd-block' : 'd-none' }}">* Password salah</small>
                                    </div>
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Tarik
                                        sekarang</button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                {{-- <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="button" type="submit" class="btn btn-primary">Tarik sekarang</button> --}}
                            </div>
                        </div>
                    </div>
                </div>
                @include('dashboard.partials.sidebar')
            @endif
            @yield('content')
        </div>
    </div>
    @if (Auth::user()->kelas_id !== null && Auth::user()->status_verifikasi_kelas === 1)
        <script>
            const buttonHandle = document.querySelector('#handlePayment');
            buttonHandle.addEventListener('click', function() {
                if ({{ $pemasukanData === null ? 1 : 0 }} === 1) {
                    const user = `{{ Auth::user()->uuid }}`;
                    const email = `{{ strval(Auth::user()->email) }}`;
                    const name = `{{ strval(Auth::user()->name) }}`;
                    const no_hp = `{{ strval(Auth::user()->no_hp) }}`;

                    $.ajax({
                        url: "/api/handlePayment",
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            user: user,
                            amount: {{ App\Models\ClassTable::find(Auth::user()->kelas_id)->harga_kas }},
                            payer_email: email,
                            customer: {
                                given_name: name,
                                email: email,
                                mobile_number: no_hp,
                            }
                        },
                        success: function(response) {
                            console.log(response);
                            window.open(response, '_blank');

                        },
                        error: function(xhr, status, error) {
                            console.error('Kesalahan saat permintaan:', error);
                        }
                    })
                }

            });
        </script>
    @endif
    <!-- container-scroller -->
    <script src="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-2.0.3/datatables.min.js"></script>
    <!-- plugins:js -->
    <script src="{{ asset('dashboard/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('dashboard/assets/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/jquery.cookie.js') }}" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('dashboard/assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/misc.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="{{ asset('dashboard/assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/todolist.js') }}"></script>
    <!-- End custom js for this page -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
</body>

</html>
