<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="nav-profile-image">
                    <img src="{{ AUth::user()->profile_user !== null ? Storage::url(Auth::user()->profile_user) : asset('dashboard/assets/images/faces/face1.jpg') }}"
                        alt="profile">
                    <span class="login-status online"></span>
                    <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">{{ Auth::user()->name }}</span>
                    <span
                        class="text-secondary text-small">{{ Auth::user()->isBendahara ? 'Bendahara' : 'Siswa' }}</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link"
                href={{ request()->route()->getName() === 'home.show' ? '' . request()->route()->parameters()['home'] : '/home' }}>
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#pemasukan" aria-expanded="false"
                aria-controls="pemasukan">
                <span class="menu-title">Transaksi</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-import menu-icon"></i>
            </a>
            <div class="collapse" id="pemasukan">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="/pemasukan">Pemasukan</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="/pengeluaran">Pengeluaran</a></li>
                </ul>
            </div>
        </li>

        @if (Auth::user()->isBendahara === 1)
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#student" aria-expanded="false"
                    aria-controls="student">
                    <span class="menu-title">Siswa</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-account-multiple menu-icon"></i>
                </a>
                <div class="collapse" id="student">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="/manage-user">Manage student</a>
                        </li>
                        <li class="nav-item"> <a class="nav-link" href="/keluar">Permission leave</a></li>
                        <li class="nav-item"> <a class="nav-link" href="/verification-user">Verification user</a></li>
                    </ul>
                </div>
            </li>
        @endif
        <li class="nav-item">
            <a class="nav-link"
                href="{{ request()->route()->getName() === 'get-laporan' ? '' . request()->route()->parameters()['kode_kelas'] : '/home?pages=laporan' }}">
                <span class="menu-title">Laporan</span>
                <i class="mdi mdi-file-document menu-icon"></i> </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/bendahara-activity">
                <span class="menu-title">Aktivitas bendahara</span>
                <i class="mdi mdi-account-convert menu-icon"></i>
            </a>
        </li>
        @if (Auth::user()->isBendahara === 1)
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home.edit', Auth::user()->kelas_id) }}">
                    <span class="menu-title">Setting</span>
                    <i class="mdi mdi-settings menu-icon"></i>
                </a>
            </li>
        @endif
        {{-- <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#balance" aria-expanded="false" aria-controls="student">
                <span class="menu-title">Balance</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-medical-bag menu-icon"></i>
            </a>
            <div class="collapse" id="balance">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="pages/samples/blank-page.html">Saldo
                            digital</a></li>
                    <li class="nav-item"> <a clasws="nav-link" href="pages/samples/login.html">Saldo
                            fisik</a></li>
                </ul>
            </div>
        </li> --}}
        <li class="nav-item sidebar-actions">
            <span class="nav-link">
                <div class="border-bottom">
                    <h6 class="font-weight-normal mb-3 text-center">Pembayaran kas</h6>
                </div>
            </span>
            <div class="">
                <button class="btn btn-block btn-lg btn-gradient-primary w-100" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">+ Kas</button>
            </div>
            @if (Auth::user()->isBendahara === 1)
                <div class="mt-3">
                    <button class="btn btn-block btn-lg btn-gradient-primary w-100" data-bs-toggle="modal"
                        data-bs-target="#penarikan">- Penarikan</button>
                </div>
            @endif
            @if ($leaveData == null)
                <div class="mt-3">
                    <button class="btn btn-block btn-lg btn-danger  w-100" data-bs-toggle="modal"
                        data-bs-target="#userKeluar">Keluar kelas</button>
                </div>
            @else
                <div class="mt-3">
                    <button class="btn btn-block btn-lg btn-warning  w-100"
                        onclick="window.location.href='{{ route('keluar.batalKeluar', $leaveData->id) }}'">Batalkan
                        keluar kelas</button>
                </div>
            @endif

        </li>
    </ul>
</nav>
