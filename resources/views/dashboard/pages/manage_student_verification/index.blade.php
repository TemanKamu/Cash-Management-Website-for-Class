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
                                <input type="search" name="email" class="form-control" placeholder="Search email"
                                    id="" value="{{ isset($_GET['email']) ? $_GET['email'] : '' }}">
                            </div>
                            <button class="btn btn-success w-100">Filter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex w-100 justify-content-center">
        <div class="col-12 grid-margin">
            {{-- <form action="" method="GET">
                <input type="search" name="name" class="form-control w-50" id="myInput" placeholder="Search for names, emails...">
            </form> --}}
            <div>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#filterModal">Filter</button>
            </div>
            <table class="table table-striped" id="table-paginate">
                <thead>
                    <tr>
                        <th> # </th>
                        <th> Photo Profile</th>
                        <th> Nama </th>
                        <th> Email </th>
                        <th> Aksi </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $item)
                        <tr>
                            <td> {{ $loop->iteration }} </td>
                            <td class="py-1">
                                <img src="{{ $item->profile_user ? Storage::url($item->profile_user) : asset('dashboard/assets/images/faces/face1.jpg') }}"
                                    alt="image" />
                            </td>
                            <td> {{ $item->name }} </td>
                            <td>
                                {{ $item->email }}
                            </td>
                            <td>
                                <form action="{{ route('verification-user.update', $item->id) }}" method="POST">
                                    @method('PUT')
                                    @csrf
                                    <button class="btn btn-success" type="submit">Terima</button>
                                </form>
                                <form action="{{ route('verification-user.destroy', $item->id) }}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-danger" type="submit">Tolak</button>
                                </form>
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
@endsection
