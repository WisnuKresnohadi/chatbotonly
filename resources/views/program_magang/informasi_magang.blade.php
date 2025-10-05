@extends('partials.horizontal_menu')

@section('page_style')
<style>
  .hidden {
    display: none;
  }

  .btn-success {
    color: #fff;
    background-color: #4EA971 !important;
    border-color: #4EA971 !important;
  }
</style>

@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="sec-title mt-4 mb-4" style="margin-left:50px;">
    <h4>Informasi Magang</h4>
  </div>

  <div class="accordion mt-3 " id="accordionExample">
    <div class="card accordion-item active ms-5 me-5">
      <h2 class="accordion-header" id="headingOne">
        <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="true" aria-controls="accordionOne">
          Magang Fakultas (1 & 2 Semester)
        </button>
      </h2>

      <div id="accordionOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          <p>Magang Fakultas adalah magang pada perusahaan yang disediakan oleh LKM FIT (lihat daftar perusahaan <a href="https://bit.ly/LowonganKPMagangFIT">https://bit.ly/LowonganKPMagangFIT</a>);<br>
            Proses pendaftaran magang fakultas ini dibantu oleh LKM FIT, sehingga mahasiswa hanya daftar magang dengan mengakses lowongan yang tersedia pada aplikasi, proses seleksi dan penerimaan selanjutnya dibantu oleh LKM.</p>

          <div class="card border">
            <div class="table-responsive text-nowrap">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Dokumen Sebelum Magang</th>
                    <th>Dokumen Setelah Magang</th>
                  </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                  <tr>
                    <td>1. Form pendaftaran online skema fakultas <br>
                      2. Surat Pengantar dibuat LKM <br>
                      3. Surat Penerimaan dari perusahaan <br>
                      (dilaporkan oleh LKM ke mahasiswa)</td>
                    <td>1. Laporan Akhir (terdapat lembar pengesahan yang ditanda-tangani <br>
                      pembimbing lapangan dan dosen pembimbing akademik) <br>
                      2. Sertifikat / Surat Selesai Magang<br>
                      3. Lembar Aktivitas Harian Magang<br>
                      4. Nilai Pembimbing Lapangan<br>
                      5. Nilai Akhir Magang (oleh dosen pembimbing akademik)</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <p class="mb-1 mt-3">
            Catatan :
          </p>
          1. lowongan magang fakultas terbuka untuk seluruh mahasiswa. <br>
          2. Prodi mungkin akan merekomendasikan mahasiswa tertentu untuk melaksanakan magang fakultas, mahasiswa tersebut wajib mengikuti rekomendasi prodi.<br>
          3. [Magang 6 bulan] Bila magang dilaksanakan kurang dari 6 bulan akibat dari aturan perusahaan, maka mahasiswa direkomendasikan melanjutkan magang di FIT untuk menggenapkan magang menjadi 6 bulan.<br>
          4. [Magang 12 bulan] Bila magang dilaksanakan 12 bulan di perusahaan, maka :
          <ul>
            <li>Prodi akan melakukan ekivalensi semua nilai mata kuliah sama dengan nilai magang pada 2 semester, yakni semester 5 dan 6 (untuk D3), atau semester 7 dan 8 (untuk Sarjana Terapan);</li>
            <li>Perusahaan harus mengeluarkan 2 kali nilai yakni nilai_1 (untuk 6 bulan pertama) dan nilai_2 (untuk 6 bulan terakhir).</li>
            <li>Apabila mahasiswa sudah lulus kuliah namun masih magang, maka :</li>
            i. Nilai yang dimasukkan ke igracias diambil dari Nilai Pembimbing Lapangan saja;<br>
            ii. Mahasiswa harus melanjutkan magang walau sudah lulus kuliah dengan catatan : ijazah dan berkas kelulusan lainnya diberikan setelah selesai magang 12 bulan. Selesai magang ditandai dengan adanya Sertifikat / Surat Selesai magang dari perusahaan.
          </ul>
          <p>
            Informasi selanjutnya mengenai program magang MBKM dan lowongan Magang MBKM dapat klik tombol dibawah ini.
          </p>
          <div class="text-center mb-4">
            <a href="/lowongan/magang">
              <button class="btn btn-success">Cari magang </button>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="card accordion-item ms-5 me-5">
      <h2 class="accordion-header" id="headingTwo">
        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionTwo" aria-expanded="false" aria-controls="accordionTwo">
          Magang MBKM - Kampus Merdeka
        </button>
      </h2>
      <div id="accordionTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          <p>Magang MBKM adalah magang yang dilaksanakan oleh Kemendikbud dan Bagian Perkuliahan Universitas dan Luar Program Studi Studi (BPUPLS dahulu PPDU) Universitas Telkom guna mendukung program Merdeka Belajar Kampus Merdeka (MBKM). </p>
          <div class="card border">
            <div class="table-responsive text-nowrap">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Dokumen Sebelum Magang</th>
                    <th>Dokumen Setelah Magang</th>
                  </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                  <tr>
                    <td>1. Form pendaftaran online skema fakultas <br>
                      2. Surat Pengantar dibuat LKM <br>
                      3. Surat Penerimaan dari perusahaan <br>
                      (dilaporkan oleh LKM ke mahasiswa)</td>
                    <td>1. Laporan Akhir (terdapat lembar pengesahan yang ditanda-tangani <br>
                      pembimbing lapangan dan dosen pembimbing akademik) <br>
                      2. Sertifikat / Surat Selesai Magang<br>
                      3. Lembar Aktivitas Harian Magang<br>
                      4. Nilai Pembimbing Lapangan<br>
                      5. Nilai Akhir Magang (oleh dosen pembimbing akademik)</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <p class="mb-1 mt-3">
            Catatan :
          </p>
          1. Magang MBKM ini biasa di laksanakan pada semester Ganjil (5/7) selama 4 s.d 6 bulan dan bisa di ekuivalensi menjadi 20 SKS mata kuliah non-magang pada semester (5/7), sehingga mahasiswa masih mengambil magang kembali pada semester genap (6/8). Apabila ada lowongan magang MBKM dari pemerintah pada semester genap (6/8), mahasiswa diperkenankan mengikuti magang MBKM kembali untuk memenuhi MK Magang.<br>
          2. [Magang 6 bulan] Bila magang dilaksanakan kurang dari 6 bulan akibat dari aturan perusahaan, maka mahasiswa direkomendasikan melanjutkan magang di FIT untuk menggenapkan magang menjadi 6 bulan.<br>
          3. [Magang 12 bulan] Bila magang dilaksanakan 12 bulan di perusahaan, maka :
          <ul>
            <li>Prodi akan melakukan ekivalensi semua nilai mata kuliah sama dengan nilai magang pada 2 semester, yakni semester 5 dan 6 (untuk D3), atau semester 7 dan 8 (untuk Sarjana Terapan);</li>
            <li> Perusahaan harus mengeluarkan 2 kali nilai yakni nilai_1 (untuk 6 bulan pertama) dan nilai_2 (untuk 6 bulan terakhir).</li>
            <li> Apabila mahasiswa sudah lulus kuliah namun masih magang, maka : </li>
            a. Nilai yang dimasukkan ke igracias diambil dari Nilai Pembimbing Lapangan saja;<br>
            b. Mahasiswa harus melanjutkan magang walau sudah lulus kuliah dengan catatan : ijazah dan berkas kelulusan lainnya diberikan setelah selesai magang 12 bulan. Selesai magang ditandai dengan adanya Sertifikat / Surat Selesai magang dari perusahaan atau Kemendikbud.
          </ul>
          <p>
            Informasi selanjutnya mengenai Program Magang MBKM dapat diakses melalui website kampus merdeka..
          </p>
        </div>
      </div>
    </div>
    <div class="card accordion-item ms-5 me-5">
      <h2 class="accordion-header" id="headingThree">
        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionThree" aria-expanded="false" aria-controls="accordionThree">
          Magang Mandiri
        </button>
      </h2>
      <div id="accordionThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          <p>Magang Mandiri adalah magang pada perusahaan di luar yang disediakan oleh LKM FIT. proses administrasi dari magang ini bersifat mandiri sejak pendaftaran hingga pengumpulan berkas.
          </p>
          <div class="card border">
            <div class="table-responsive text-nowrap">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Dokumen Sebelum Magang</th>
                    <th>Dokumen Setelah Magang</th>
                  </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                  <tr>
                    <td>1. Form pendaftaran online skema fakultas <br>
                      2. Surat Pengantar dibuat LKM <br>
                      3. Surat Penerimaan dari perusahaan<br>
                      (dilaporkan oleh LKM ke mahasiswa)</td>
                    <td>1. Laporan Akhir (terdapat lembar pengesahan yang ditanda-tangani <br> pembimbing lapangan dan dosen pembimbing akademik)
                      2. Sertifikat / Surat Selesai Magang <br>
                      3. Lembar Aktivitas Harian Magang <br>
                      4. Nilai Pembimbing Lapangan <br>
                      5. Nilai Akhir Magang (oleh dosen pembimbing akademik)</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card accordion-item ms-5 me-5">
      <h2 class="accordion-header" id="headingFour">
        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionFour" aria-expanded="false" aria-controls="accordionFour">
          Magang Kerja
        </button>
      </h2>
      <div id="accordionFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          <p>
            Magang Kerja adalah kegiatan magang bagi mahasiswa yang telah bekerja dapat diakui pengalaman kerjanya sebagai kegiatan Magang dan Proyek Akhir. Hal tersebut untuk efisiensi waktu kuliah mahasiswa.
          </p>
          <div class="card border">
            <div class="table-responsive text-nowrap">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Dokumen Sebelum Magang</th>
                    <th>Dokumen Setelah Magang</th>
                  </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                  <tr>
                    <td>1. Form pendaftaran online skema fakultas <br>
                      2. Surat Pengantar dibuat LKM <br>
                      3. Surat Penerimaan dari perusahaan<br>
                      (dilaporkan oleh LKM ke mahasiswa)</td>
                    <td>1. Laporan Proyek Akhir, Magang dan Kerja (template soon) <br>
                      2. Slip Gaji 3 bulan, minimal besaran gaji per bulan 1.25xUMR di kota domisili kantor. <br>
                      3. Presensi Kehadiran Kantor selama 6 bulan. <br>
                      4. Nilai Supervisor, Asisten Manajer dan Manajer.<br>
                      5. Nilai Akhir Magang (oleh dosen pembimbing akademik)</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <p class="mb-1 mt-3">
            Catatan : Perusahaan tempat kerja harus berfirma (CV atau PT) dan sudah berjalan selama minimal 3 tahun (dilihat dari Surat Ijin Usaha atau sejenisnya yang dilaporkan kepada LKM FIT).
          </p>
        </div>
      </div>
    </div>
    <div class="card accordion-item ms-5 me-5 mb-5">
      <h2 class="accordion-header" id="headingFive">
        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionFive" aria-expanded="false" aria-controls="accordionFive">
          Magang StartUp
        </button>
      </h2>
      <div id="accordionFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          <p>
            Magang Startup adalah magang pada StartUp yang dikelola Inkubator atau Pengelola StartUp di Universitas Telkom. Magang ini tidak melakukan pekerjaan pada umumnya di perusahaan, namun membangun dan mengelola perusahaan untuk menghasilkan pendapatan perusahaan.<br>
            Proses pembentukan StartUp ini tidak dalam waktu yang singkat (6 bulan). butuh persiapan minimal satu tahun untuk melihat sebuah StartUp terbentuk. Bagi mahasiswa yang memiliki StartUp, berikut administrasi yang diperlukan LKM untuk mengakui nilai magangnya.
          </p>

          <div class="card border">
            <div class="table-responsive text-nowrap">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Dokumen Sebelum Magang</th>
                    <th>Dokumen Setelah Magang</th>
                  </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                  <tr>
                    <td>1. Form pendaftaran skema StartUp <br>
                      2. Tidak dibuat Surat Pengantar, LKM menerima daftar mahasiswa dari Kaprodi <br>
                      3. Lembar Lulus Evaluasi Magang dari Inkubator atau Pengelola StartUp <br> (dilaporkan dari mahasiswa ke LKM)</td>
                    <td>1. Laporan Akhir (terdapat lembar pengesahan yang ditanda-tangani <br>
                      pendamping StartUp dan dosen pembimbing akademik) <br>
                      2. Surat Selesai Magang dengan rekomendasi nilai dari pembina StartUp <br>
                      3. Pitchdesk Inkubasi StartUp <br>
                      4. Nilai Dosen Pembimbing</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('page_script')
<script>


</script>
@endsection