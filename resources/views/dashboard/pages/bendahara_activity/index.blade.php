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
                        <form action="">
                            <div class="form-group">
                                <select name="user" id="" class="form-select">
                                    <option value="all_user">All user</option>
                                    @foreach ($datas->userData as $item)
                                        <option value="{{ $item->uuid }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="date_at_id" class="form-label">Date at</label>
                                <input type="date" class="form-control" name="date_at" id="date_at_id"
                                    value="{{ isset($_GET['date_at']) ? $_GET['date_at'] : '' }}">
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Date to</label>
                                <input type="date" class="form-control" name="date_to" id="date_to_id"
                                    value="{{ isset($_GET['date_to']) ? $_GET['date_to'] : '' }}">
                            </div>
                            <button class="btn btn-success w-100">Filter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row w-100 mx-auto">
        <div class="flex-wrap col-sm-12 col-xl-12">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#filterModal">Filter</button>
                </div>
                <div class="breadcrumb-item active " data-bs-toggle="tooltip" data-bs-placement="bottom"
                    title="Pemasukan akan selalu di tambahkan setiap pukul 00.00">
                    <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i> <span>Info</span>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-responsive table-borderless" id="table-paginate">

                    <thead>
                        <tr class="bg-light">
                            <th scope="col" width="5%">#</th>
                            <th scope="col" width="20%">Nama</th>
                            <th scope="col" width="20%">Deskripsi</th>
                            <th scope="col" width="20%">Tanggal dan waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="{{ $data->system_message === 1 ? 'text-danger' : 'text-primary' }}">
                                    {{ $data->system_message === 1 ? 'Sistem' : $data->user->name }}</td>
                                <td>{{ $data->description }}</td>
                                <td>{{ $data->created_at->format('d-m-Y H:i:s') }}</td>
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
        const dateAt = document.getElementById("date_at_id");
        const dateTo = document.getElementById("date_to_id");

        if (dateAt.value === "" && dateTo.value === "") {
            dateAt.valueAsDate = new Date();
            dateTo.valueAsDate = new Date();
        }
    </script>
@endsection
