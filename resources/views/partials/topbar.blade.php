<ul class="menu-inner">
    <!-- Lowongan Magang -->
    <li class="menu-item">
        <a href="{{ route('apply_lowongan') }}" class="menu-link">
            <div data-i18n="Lowongan Magang">Lowongan Magang</div>
        </a>
    </li>
    <!-- Perusahaan -->
    <li class="menu-item">
        <a href="{{ route('daftar_perusahaan') }}" class="menu-link">
            <div data-i18n="Mitra Perusahaan">Mitra Perusahaan</div>
        </a>
    </li>

    @role('Mahasiswa')
    <!-- Kegiatan Saya -->
    <li class="menu-item">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
            <div data-i18n="Kegiatan Saya">Kegiatan Saya</div>
        </a>

        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{ route('logbook') }}" class="menu-link">
                    <div data-i18n="Logbook Mahasiswa">Logbook Mahasiswa</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('lamaran_saya') }}" class="menu-link">
                    <div data-i18n="Status Lamaran Magang">Status Lamaran Magang</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('nilai_magang') }}" class="menu-link">
                    <div data-i18n="Nilai Magang">Nilai Magang</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('berkas_akhir') }}" class="menu-link">
                    <div data-i18n="Berkas Akhir Magang">Berkas Akhir Magang</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('lowongan_tersimpan') }}" class="menu-link">
                    <div data-i18n="Lowongan Tersimpan">Lowongan Tersimpan</div>
                </a>
            </li>
        </ul>
    </li>
    @endrole

    <!-- Layanan LKM -->
    <li class="menu-item">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
            <div data-i18n="Layanan LKM">Layanan LKM</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="/pengajuan/surat" class="menu-link">
                    <div data-i18n="Pengajuan Magang">Pengajuan Magang</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="/informasi/magang" class="menu-link">
                    <div data-i18n="Informasi Magang">Informasi Magang</div>
                </a>
            </li>
        </ul>
    </li>
    <!-- Tentang Kami -->
    <li class="menu-item">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
            <div data-i18n="Tentang Kami">Tentang Kami</div>
        </a>

        <ul class="menu-sub">
            <li class="menu-item">
                <a href="/aboutus/talentern" class="menu-link">
                    <div data-i18n="Talentern">Talentern</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="/aboutus/techno" class="menu-link">
                    <div data-i18n="Techno Infinity">Techno Infinity</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="/aboutus/lkmfit" class="menu-link">
                    <div data-i18n="Layanan Kerjasama dan Magang Fakultas Ilmu Terapan">
                        Layanan Kerjasama dan Magang Fakultas Ilmu Terapan
                    </div>
                </a>
            </li>
        </ul>
    </li>
    <li class="menu-item">
        <a href="#footer" class="menu-link">
            <div data-i18n="Kontak Kami">Kontak Kami</div>
        </a>
    </li>
</ul>