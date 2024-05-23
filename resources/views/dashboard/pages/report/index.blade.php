@extends('dashboard.layout.index')

@section('content')
    <div class="row w-100 ">
        <div class="col-md-12">
            <div class="card mx-auto">
                <div class="card-header">
                    <h5>Laporan</h5>
                </div>
                <div class="card-body p-1">
                    <form onsubmit="return convertToExcel(event)" class="mt-4">
                        <div class="form-group">
                            <label for="" class="form-label">Laporan</label>
                            <select name="" id="laporan" class="form-select" onchange="whichLaporan(this.value)">
                                @if (Auth::user()->isBendahara === 1)
                                    <option value="pemasukan"
                                        {{ isset($_GET['laporan']) && $_GET['laporan'] === 'pemasukan' ? 'selected' : '' }}>
                                        Pemasukan</option>
                                @endif
                                <option value="pengeluaran"
                                    {{ isset($_GET['laporan']) && $_GET['laporan'] === 'pengeluaran' ? 'selected' : '' }}>
                                    Pengeluaran</option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Search</label>
                            <select class="js-example-disabled-results form-select" id="userSearch">
                                <option value="all_user">All user</option>
                                @foreach ($user as $item)
                                    <option value="{{ $item->uuid }}">{{ $item->name }} | {{ $item->email }} |
                                        {{ $item->isBendahara ? 'Bendahara' : 'Siswa' }}</option>
                                @endforeach
                                {{-- <option value="two" disabled="disabled">Second (disabled)</option> --}}
                            </select>
                            {{-- <input type="email" class="form-control" id="userSearch" placeholder="Search User by email"
                                onchange="searchData()">
                            <span class="pt-2 d-none" id="searchResult"> </span> <span class="text-success d-none"
                                id="dataResult">
                            </span> --}}
                        </div>
                        <div class="form-group">
                            @if (isset($_GET['laporan']) && $_GET['laporan'] === 'pemasukan')
                                <label for="" class="form-label">Status</label>
                                <select name="" id="select-status" class="form-select"
                                    onchange="hideMethodPembayaran(this.value)">
                                    <option selected value="all_status">All status</option>
                                    <option value="sudah bayar">Sudah bayar</option>
                                    <option value="belum bayar">Belum bayar</option>
                                    <option value="pending">Pending</option>
                                </select>
                            @elseif(isset($_GET['laporan']) && $_GET['laporan'] === 'pengeluaran')
                                <label for="" class="form-label">Status</label>
                                <select name="" id="select-status" class="form-select"
                                    onchange="hideMethodPembayaran(this.value)">
                                    <option selected value="all_status">All status</option>
                                    <option value="berhasil">Berhasil</option>
                                    <option value="pending">Pending</option>
                                    <option value="gagal">Gagal</option>
                                </select>
                            @else
                                <label for="" class="form-label">Status</label>
                                <select name="" id="select-status" class="form-select"
                                    onchange="hideMethodPembayaran(this.value)">
                                    <option selected value="all_status">All status</option>
                                    <option value="sudah bayar">Sudah bayar</option>
                                    <option value="belum bayar">Belum bayar</option>
                                    <option value="pending">Pending</option>
                                </select>
                            @endif
                        </div>
                        <div class="form-group" id="metodePembayaran">
                            <label for="" class="form-label">Metode pembayaran / transfer</label>
                            <select name="" id="metodePembayaranSelect" class="form-select">
                                <option selected value="all_metode" id="willSelected">All metode</option>
                                <option value="cash">Cash</option>
                                <option value="transfer">Transfer</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Date at</label>
                            <input type="date" name="date_at" id="date_at_id" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Date to</label>
                            <input type="date" name="date_to" id="date_to_id" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-gradient-success btn-icon-text w-100">
                            <i class="mdi mdi-file-check btn-icon-prepend"></i> Download </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        var $disabledResults = $(".js-example-disabled-results");
        $disabledResults.select2();
    </script>
    <script>
        document.getElementById("date_at_id").valueAsDate = new Date();
        document.getElementById("date_to_id").valueAsDate = new Date();

        const currentURL = window.location.href;
        const path = new URL(currentURL).pathname;
        const parts = path.split("/");
        const kelasId = parts[parts.length - 1];

        function hideMethodPembayaran(value) {
            const metodePembayaran = document.getElementById("metodePembayaran");
            if (value === "belum_bayar") {
                metodePembayaran.classList.remove("d-block");
                metodePembayaran.classList.add("d-none");
                document.getElementById("willSelected").selected = true;
            } else {
                metodePembayaran.classList.remove("d-none");
                metodePembayaran.classList.add("d-block");
            }
        }

        function whichLaporan(value) {
            window.location.href = `?laporan=${value}`
        }
        // function searchData() {
        //     const user = document.getElementById("userSearch");
        //     const dataResult = document.getElementById("dataResult");
        //     $.ajax({
        //         url: `/api/laporan/checkuser`,
        //         type: "POST",
        //         data: {
        //             kode_kelas: kelasId,
        //             email: user.value
        //         },
        //         success: function(response) {
        //             const searchResult = document.getElementById("searchResult");
        //             console.log(response)
        //             if (response.name === undefined) {
        //                 searchResult.innerText = "Data tidak ditemukan";
        //                 if (dataResult.classList.contains("d-none")) {
        //                     dataResult.classList.remove("d-none");
        //                     if (searchResult.classList.contains("d-none")) {
        //                         searchResult.classList.remove("d-none");
        //                     } else {
        //                         searchResult.classList.add("d-none");
        //                     }
        //                 } else {
        //                     dataResult.classList.add("d-none");
        //                 }
        //             } else {
        //                 if (searchResult.classList.contains("d-none")) {
        //                     searchResult.classList.remove("d-none");
        //                     if (dataResult.classList.contains("d-none")) {
        //                         dataResult.classList.remove("d-none");
        //                     }
        //                     searchResult.innerText = "Data ditemukan : ";
        //                     dataResult.innerText = response.name + " | " + response.email
        //                 } else {
        //                     searchResult.innerText = "Data ditemukan : ";
        //                     dataResult.innerText = response.name + " | " + response.email
        //                     if (dataResult.classList.contains("d-none")) {
        //                         dataResult.classList.remove("d-none");
        //                     }
        //                     // dataResult.classList.add("d-none");
        //                 }
        //             }
        //         },
        //         error: function() {
        //             alert("error");
        //         }
        //     })
        // }

        function convertToExcel(e) {
            e.preventDefault();
            $.ajax({
                url: `/api/laporan`,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    kode_kelas: kelasId,
                    user: document.getElementById("userSearch").value,
                    laporan: document.getElementById("laporan").value,
                    status: document.getElementById("select-status").value,
                    metode_pembayaran: document.getElementById("metodePembayaranSelect").value,
                    date_at: document.getElementById("date_at_id").value,
                    date_to: document.getElementById("date_to_id").value
                },
                success: function(response) {
                    console.log(response)
                    var jsonData = response;
                    var wb = XLSX.utils.book_new();
                    var ws = XLSX.utils.json_to_sheet(jsonData);
                    XLSX.utils.book_append_sheet(wb, ws, "Sheet1");

                    XLSX.writeFile(wb, "laporan_kelas.xlsx");
                },
                error: function(xhr, status, error) {
                    console.error('Kesalahan saat permintaan:', error);
                }
            })
        }
    </script>
@endsection
