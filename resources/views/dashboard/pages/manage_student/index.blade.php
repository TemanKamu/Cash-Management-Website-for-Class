@extends('dashboard.layout.index')

@section('content')
    <div class="modal fade" id="kickSiswa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('manage-student.kickSiswa') }}" id="kickStudentForm" method="POST">
                    <div class="modal-body">
                        @csrf
                        <!-- Hidden input to pass the student ID -->
                        <input type="hidden" name="siswa_id" id="student_id_user">
                        <input type="hidden" name="bendahara_id" value="{{ Auth::user()->id }}">

                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Alasan:</label>
                            <textarea class="form-control" id="message-text" name="alasan"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="send-message-btn">Send
                            message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Filter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="card-body p-1">
                        <form action="{{ url('/manage-user') }}" method="GET">
                            <div class="form-group">
                                <label for="userId" class="form-label">Name,Email Or Phone number</label>
                                <input type="text" class="form-control" name="user" id="userId">
                                <input type="hidden" name="kelas_id" value="{{ Auth::user()->kelas_id }}">
                            </div>
                            <div class="forn-group mb-4">
                                <label for="jabatan_id" class="mb-2">Jabatan</label>
                                <select name="jabatan" id="jabatan_id" class="form-select">
                                    <option value="all_jabatan">All</option>
                                    <option value="0">Siswa</option>
                                    <option value="1">Bendahara</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Filter</button>
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
            </div>
            <div class="table-responsive">
                {{-- <button class="btn btn-primary mb-2">Create new</button> --}}
                <table class="table table-responsive table-borderless" id="table-paginate">
                    <thead>
                        <tr class="bg-light">

                            <th scope="col" width="5%"> # </th>
                            <th scope="col" width="20%"> Photo Profile</th>
                            <th scope="col" width="20%"> Nama </th>
                            <th scope="col" width="20%"> Email </th>
                            <th scope="col" width="20%"> No hp </th>
                            <th scope="col" width="20%"> Jabatan </th>
                            <th scope="col" width="20%" class="text-center"> Aksi </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $item)
                            <tr>
                                <td> {{ $loop->iteration }} </td>
                                <td class="py-1 text-center">
                                    <img src="{{ $item->profile_user ? Storage::url($item->profile_user) : asset('dashboard/assets/images/faces/face1.jpg') }}"
                                        alt="image" />
                                </td>
                                <td> {{ $item->name }} </td>
                                <td>
                                    {{ $item->email }}
                                </td>
                                <td>{{ $item->no_hp }}</td>
                                <td> {{ $item->isBendahara ? 'Bendahara' : 'Siswa' }} </td>
                                <td>
                                    <button class="btn btn-danger {{ $item->isBendahara ? 'disabled' : '' }}"
                                        data-bs-toggle="modal" data-bs-target="#kickSiswa" data-bs-whatever="@mdo"
                                        onclick="kickStudent({{ $item->id }}, '{{ $item->name }}')">Keluarkan</button>
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
        function kickStudent(studentId, studentName) {
            const inputModal = document.getElementById('student_id_user');
            const titleModal = document.getElementById('exampleModalLabel');
            titleModal.innerText = `Keluarkan Siswa: ${studentName}`
            inputModal.value = studentId
        }
    </script>
@endsection
