@php
    $user = auth()->user();
    if ($user->hasRole('Mahasiswa')){
        $url = route('profile');
    }else if($user->hasAnyRole(['Dosen', 'Kaprodi', 'Mitra', 'LKM', 'Super Admin', 'Pembimbing Lapangan', 'Koordinator Magang'])){
        $url = route('profile_detail.informasi-pribadi');
    }
@endphp
<ul class="dropdown-menu dropdown-menu-end">
    @hasanyrole(['Super Admin', 'LKM'])
        <li>
            <a class="dropdown-item" href="{{ route('dashboard_admin') }}">
                <i class="ti ti-database me-2 ti-sm"></i>
                <span class="align-middle">Dashboard</span>
            </a>
        </li>
    @else
    @can('dashboard.dashboard_mitra')
        <li>
            <a class="dropdown-item" href="{{ route('dashboard_company') }}">
                <i class="ti ti-database me-2 ti-sm"></i>
                <span class="align-middle">Dashboard</span>
            </a>
        </li>
    @endcan
    @if ($user->canany(['approval_mhs_kaprodi.view', 'data_mahasiswa_magang_kaprodi.view']))
        <li>
            <a class="dropdown-item" href="{{ route('approval_mahasiswa_kaprodi') }}">
                <i class="ti ti-database me-2 ti-sm"></i>
                <span class="align-middle">Dashboard</span>
            </a>
        </li>
    @elseif ($user->canany(['approval_mhs_doswal.view', 'data_mahasiswa_magang_dosen.view']))
        <li>
            <a class="dropdown-item" href="{{ route('approval_mahasiswa_doswal') }}">
                <i class="ti ti-database me-2 ti-sm"></i>
                <span class="align-middle">Dashboard</span>
            </a>
        </li>
    @elseif ($user->can('kelola_mhs_pemb_akademik.view'))
        <li>
            <a class="dropdown-item" href="{{ route('kelola_mhs_pemb_akademik') }}">
                <i class="ti ti-database me-2 ti-sm"></i>
                <span class="align-middle">Dashboard</span>
            </a>
        </li>
    @endif
    @can('kelola_magang_pemb_lapangan.view')
        <li>
            <a class="dropdown-item" href="{{ route('kelola_magang_pemb_lapangan') }}">
                <i class="ti ti-database me-2 ti-sm"></i>
                <span class="align-middle">Dashboard</span>
            </a>
        </li>
    @endcan
    @endhasanyrole
    <li>
        <a class="dropdown-item"
            href="{{ $url }}">
            <i class="ti ti-user-circle me-2 ti-sm"></i>
            <span class="align-middle">Profil</span>
        </a>
    </li>
    {{-- <li>
        <a class="dropdown-item" href="/pengaturan">
            <i class="ti ti-settings me-2 ti-sm"></i>
            <span class="align-middle">Pengaturan Akun</span>
        </a> --}}
    </li>
    <li>
        <div class="dropdown-divider"></div>
    </li>
    <li>
        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deleteModal"
            href="{{ route('logout') }}">
            <i class="ti ti-logout me-2 ti-sm"></i>
            <span class="align-middle">Keluar</span>
        </a>
    </li>
</ul>
