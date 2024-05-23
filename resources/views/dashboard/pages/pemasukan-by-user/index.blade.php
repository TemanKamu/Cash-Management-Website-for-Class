@extends('dashboard.layout.index')

@section('content')
    <div class="modal fade" id="bayarKasInDate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <small id="paymentDate1"></small>
                            </p>
                            <p class="m-1">
                                <small id="paymentStatus"></small>
                            </p>
                        </header>
                        <article>
                            <hr>
                            <p class="d-flex justify-content-between m-1">
                                <small>Bayar kas pada tanggal
                                    <span id="paymentDate2"></span></small>
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
                    <button type="button" class="btn btn-primary" id="handlePaymentUser">Bayar
                        sekarang</button>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex w-100 justify-content-center">
        <div class="col-12 grid-margin">
            <table class="table table-striped" id="table-paginate">
                <thead>
                    <tr>
                        <th> # </th>
                        <th> No </th>
                        <th> Tanggal</th>
                        <th> Metode pembayaran </th>
                        <th> Jumlah pembayaran </th>
                        <th> Status </th>
                        <th> Aksi </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $item)
                        <tr>
                            <td><input type="checkbox" name="checkbox_name" value="checkox_value"></td>
                            <td> {{ $loop->iteration }} </td>
                            <td>{{ $item->created_at }}</td>
                            <td> {{ $item->metode_pembayaran ? $item->metode_pembayaran : 'Kosong' }} </td>
                            <td>
                                Rp {{ number_format($item->jumlah_pemasukan) }}
                            </td>
                            <td>{{ $item->status }}</td>
                            <td>
                                @if ($item->status === 'belum bayar')
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#bayarKasInDate"
                                        data-bs-whatever="@mdo"
                                        onclick="changeModalPayment('{{ $item->created_at->format('d-m-Y') }}', '{{ $item->status }}', '{{ $item->created_at }}')">Bayar
                                        sekarang</button>
                                @else
                                    <button class="btn btn-success disabled">Sudah bayar</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-2.0.3/datatables.min.js"></script>
    <script>
        $('#table-paginate').DataTable()
    </script>
    <script>
        let date = null;
        function changeModalPayment(tanggal, status, tanggal2) {
            date = tanggal2;
            document.getElementById('paymentDate1').innerHTML = tanggal
            document.getElementById('paymentDate2').innerHTML = tanggal
            document.getElementById('paymentStatus').innerHTML = status

        }
        const buttonHandleUser = document.querySelector('#handlePaymentUser');
        buttonHandleUser.addEventListener('click', function() {
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
                    date: date,
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
        });
    </script>
@endsection
