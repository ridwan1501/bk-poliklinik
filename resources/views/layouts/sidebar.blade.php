    <div class="left-sidenav">
        <!-- LOGO -->
        <div class="brand">
            <a href="{{ url('/') }}" class="logo">
                <span class="h3">
                    {{ strtoupper(config('app.name')) }}
                </span>
            </a>
        </div>
        <!--end logo-->
        <div class="menu-content h-100" data-simplebar>
            <ul class="metismenu left-sidenav-menu">


                {{-- <li>
                    <a href="{{ route('backoffice.payment_methods.index') }}"> <i data-feather="list" class="align-self-center menu-icon"></i><span>Metode Pembayaran</span></a>
                </li> --}}

                @if(auth()->user()->role === 'admin')
                    <li class="menu-label mt-0">Main</li>
                    <li>
                        <a href=""> <i data-feather="home"class="align-self-center menu-icon"></i><span>Dashboard</span></a>
                    </li>

                    <li class="menu-label mt-0">Master Data</li>
                    <li>
                        <a href="{{ route('backoffice.poli.index') }}"> <i data-feather="list" class="align-self-center menu-icon"></i><span>Poli</span></a>
                    </li>

                    <li>
                        <a href="{{ route('backoffice.dokter.index') }}"> <i data-feather="list" class="align-self-center menu-icon"></i><span>Dokter</span></a>
                    </li>

                    <li>
                        <a href="{{ route('backoffice.jadwal_periksa.index') }}"> <i data-feather="list" class="align-self-center menu-icon"></i><span>Jadwal Periksa</span></a>
                    </li>

                    <li>
                        <a href="{{ route('backoffice.obat.index') }}"> <i data-feather="list" class="align-self-center menu-icon"></i><span>Obat</span></a>
                    </li>

                    <li>
                        <a href="{{ route('backoffice.pasien.index') }}"> <i data-feather="list" class="align-self-center menu-icon"></i><span>Pasien</span></a>
                    </li>

                    <li class="menu-label mt-0">Pemeriksaan</li>

                    <li>
                        <a href="{{ route('backoffice.registrasi.history') }}"> <i data-feather="list" class="align-self-center menu-icon"></i><span>Pemeriksaan</span></a>
                    </li>

                    <li class="menu-label mt-0">Antrian</li>

                    <li>
                        <a href="{{ route('backoffice.antrian.index') }}"> <i data-feather="list" class="align-self-center menu-icon"></i><span>Antrian</span></a>
                    </li>

                @elseif(auth()->user()->role === 'dokter')
                    <li class="menu-label mt-0">Pemeriksaan</li>
                    <li>
                        <a href="{{ route('backoffice.jadwal_periksa.index') }}"> <i data-feather="list" class="align-self-center menu-icon"></i><span>Jadwal Periksa</span></a>
                    </li>
                    <li>
                        <a href="{{ route('backoffice.registrasi.history') }}"> <i data-feather="list" class="align-self-center menu-icon"></i><span>Pemeriksaan</span></a>
                    </li>
                @elseif(auth()->user()->role === 'pasien')
                    <li class="menu-label mt-0">Main</li>
                    <li>
                        <a href="{{ route('backoffice.registrasi.index') }}"> <i data-feather="list" class="align-self-center menu-icon"></i><span>Registrasi Jadwal</span></a>
                    </li>

                    <li>
                        <a href="{{ route('backoffice.registrasi.history') }}"> <i data-feather="list" class="align-self-center menu-icon"></i><span>Riwayat Periksa</span></a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
