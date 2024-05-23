@if (
    $navbarData['bayar_kas'] === false &&
        Auth::user()->kelas_id !== null &&
        Auth::user()->status_verifikasi_kelas === 1)
    <div class="row p-0 m-0 proBanner d-flex" id="proBanner">
        <div class="col-md-12 p-0 m-0">
            <div class="card-body card-body-padding d-flex align-items-center justify-content-between">
                <div class="ps-lg-1">
                    <div class="d-flex align-items-center justify-content-between">
                        <p class="mb-0 font-weight-medium me-3 buy-now-text">Anda belum bayar kas! Segera bayar kas!</p>
                        <a href="https://www.bootstrapdash.com/product/purple-bootstrap-admin-template/?utm_source=organic&amp;utm_medium=banner&amp;utm_campaign=buynow_demo"
                            target="_blank" class="btn me-2 buy-now-btn border-0">Bayar</a>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <a href="https://www.bootstrapdash.com/product/purple-bootstrap-admin-template/"><i
                            class="mdi mdi-home me-3 text-white"></i></a>
                    <button id="bannerClose" class="btn border-0 p-0">
                        <i class="mdi mdi-close text-white me-0"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif
<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="brand-logo" href="/home"><img src="{{ asset('dashboard/assets/images/logo/logo-typho.jpg') }}"
                alt="logo" style="height:70px" /></a>
        <a class="navbar-brand brand-logo-mini" href="index.html"><img
                src="{{ asset('dashboard/assets/images/logo/logo.jpg') }}" alt="logo" /></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-stretch">
        @if (Auth::user()->status_verifikasi_kelas === 1)
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                <span class="mdi mdi-menu"></span>
            </button>
            <div class="search-field d-none d-md-block">
                <form class="d-flex align-items-center h-100" action="#">
                    <div class="input-group">
                        <div class="input-group-prepend bg-transparent">
                            <i class="input-group-text border-0 mdi mdi-magnify"></i>
                        </div>
                        <input type="text" class="form-control bg-transparent border-0"
                            placeholder="Search anyting...">
                    </div>
                </form>
            </div>
        @endif

        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <div class="nav-profile-img">
                        <img src="{{ AUth::user()->profile_user !== null ? Storage::url(Auth::user()->profile_user) :  asset('dashboard/assets/images/faces/face1.jpg') }}" alt="image">
                        {{-- <span class="availability-status online"></span> --}}
                    </div>
                    <div class="nav-profile-text">
                        <p class="mb-1 text-black">{{ Auth::user()->name }}</p>
                    </div>
                </a>
                <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="{{ route('setting-user.edit', Auth::user()->uuid) }}">
                        <i class="mdi mdi-settings me-2 text-success"></i>
                        Settings
                    </a>
                    <a class="dropdown-item" href="{{ route('pemasukan-user', Auth::user()->uuid) }}">
                        <i class="mdi mdi-access-point me-2 text-success"></i>
                        Manage your cash
                    </a>
                    <div class="dropdown-divider"></div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="dropdown-item" type="submit">
                            <i class="mdi mdi-logout me-2 text-primary" type="submit"></i> Signout
                        </button>
                    </form>
                </div>
            </li>
            <li class="nav-item d-none d-lg-block full-screen-link">
                <a class="nav-link">
                    <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-email-outline"></i>
                    @if (!$navbarData['status'] === 'off')
                        <span class="count-symbol bg-warning"></span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                    aria-labelledby="messageDropdown" style="max-width: 50px">
                    <h6 class="p-3 mb-0">Messages</h6>
                    <div class="dropdown-divider"></div>
                    @if ($navbarData['status'] === 'off')
                        <a class="dropdown-item preview-item">
                            <div
                                class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                                <h6 class="preview-subject ellipsis mb-1 font-weight-normal">No message
                                </h6>
                                {{-- <p class="text-gray mb-0"> 1 Minutes ago </p> --}}
                            </div>
                        </a>
                    @else
                        @foreach ($navbarData['message'] as $message)
                            <a class="dropdown-item preview-item" href="/mail?email_id={{ $message->id }}">
                                <div
                                    class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                                    <h6 class="preview-subject ellipsis mb-1 font-weight-normal"
                                        style="max-width:100px">
                                        {{ $message->title }}
                                    </h6>

                                    <p class="text-gray mb-0">{{ $message->human_readable_date }}</p>
                                </div>
                            </a>
                        @endforeach
                        {{-- <h6 class="p-3 mb-0 text-center">4 new messages</h6> --}}
                    @endif
                    <h6 class="p-2 px-3"><a href="/mail" class="text-black text-decoration-none">All message</a></h6>
                </div>
            </li>
            {{-- @if (Auth::user()->isBendahara === 1)
                <li class="nav-item nav-logout d-none d-lg-block">
                    <a class="nav-link" href="#">
                        <i class="mdi mdi-settings"></i>
                    </a>
                </li>
            @endif --}}

            <li class="nav-item nav-settings d-none d-lg-block">
                <a class="nav-link" href="#">
                    <i class="mdi mdi-format-line-spacing"></i>
                </a>
            </li>
        </ul>
        @if (Auth::user()->status_verifikasi_kelas === 1)
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                data-toggle="offcanvas">
                <span class="mdi mdi-menu"></span>
            </button>
        @endif
    </div>
</nav>
