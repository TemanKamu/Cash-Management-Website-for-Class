@extends('dashboard.layout.index')
@section('content')
    <style>
        #hoverCard {
            transition: background-color 0.3s ease;
        }

        #hoverCard:hover {
            background: rgb(215, 215, 215);
            cursor: pointer;
        }
    </style>
    <div class="main-panel {{ Auth::user()->kelas_id === null || Auth::user()->status_verifikasi_kelas === 0 ? 'w-100' : '' }}">
        <div class="row">
            <div class="col-{{ Auth::user()->kelas_id === null || Auth::user()->status_verifikasi_kelas === 0 ? '4' : '4' }}"
                style="overflow-y: scroll;height: 95%;">
                @if ($data->isNotEmpty())
                    @foreach ($data as $item)
                        <div class="d-flex border py-2 px-3" id="hoverCard"
                            onclick="window.location.href='?email_id={{ $item->id }}'">
                            <div class="me-3">
                                <img src="{{ $item->mailBox !== null ? Storage::url($item->user->profile_user) : asset('dashboard/assets/images/faces/face1.jpg') }}"
                                    width="50px" class="me-2 rounded-circle" alt="image">
                            </div>
                            <div class="" style="width: 100%;">
                                <div class="d-flex justify-content-between align-items-top ">
                                    <div>
                                        <p class="m-0">{{ $item->messager_name }}</p>
                                        <small
                                            class="text-muted">{{ $item->isBendahara === 'true' ? 'Bendahara' : ($item->isBendahara === 'system' ? 'Administrator' : '') }}</small>
                                    </div>
                                    <small class="text-muted">{{ $item->created_at->format('H:i:s') }}</small>
                                </div>

                                <div class="mt-3">
                                    {!! $item->title !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-center">No message yet</p>
                @endif


            </div>
            <div class="col-{{ Auth::user()->kelas_id === null || Auth::user()->status_verifikasi_kelas === 0 ? '8' : '7' }} px-4 " style="height: 100vh">
                @if (isset($_GET['email_id']))
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('dashboard/assets/images/faces/face1.jpg') }}"
                                class="img-fluid rounded-circle me-4" width="50px" alt="">
                            <span> {{ $data->mail_detail['messager_name'] }} | Bendahara</span>
                        </div>
                        <div>
                            <small class="text-muted me-4">{{ $data->mail_detail['created_at']->format('Y M d') }}</small>
                        </div>
                    </div>
                    <div class="mt-5" style="overflow: scroll; height: 80vh">
                        <p class="display-4">{{ $data->mail_detail['title'] }}</p>
                        <span class="font-weight-bold">Hallo {{ Auth::user()->name }}!</span>
                        <div class="mt-5">
                            {!! $data->mail_detail['description'] !!}
                        </div>
                        <hr>
                        <form action="{{ route('mail.destroy', $data->mail_detail['id']) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button class="btn btn-outline-danger">Delete message</button>
                        </form>
                    </div>
                @else
                    <p class="text-center">No message yet</p>
                @endif
            </div>
            {{-- <div class="col-8 px-4" style="background:rgb(255, 235, 253)" style="height: 100vh">
               No message
            </div> --}}
        </div>
    </div>
@endsection
