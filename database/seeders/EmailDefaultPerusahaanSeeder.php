<?php

namespace Database\Seeders;

use App\Models\Industri;
use Illuminate\Support\Str;
use App\Models\EmailTemplate;
use App\Enums\TemplateEmailListProsesEnum;

class EmailDefaultPerusahaanSeeder
{
    public function __construct(
        public Industri $industri,
    ){
        $this->run();
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $listProses = TemplateEmailListProsesEnum::getConstants();

        $data = [];
        foreach ($listProses as $key => $value) {
            switch ($value) {
                case TemplateEmailListProsesEnum::LOLOS_SELEKSI:
                    $subject = "Pemberitahuan Lolos Seleksi";
                    $content = "<p>Yth. [[NamaPeserta]],</p>
<p>Salam sejahtera,</p>
<p>Kami ingin mengucapkan selamat karena Anda telah lolos <strong>[[TahapSeleksi]]</strong> untuk program magang di <strong>[[Perusahaan]]</strong> pada posisi <strong>[[PosisiMagang]]</strong>. Kami sangat mengapresiasi antusiasme dan kualifikasi yang Anda tunjukkan dalam proses seleksi ini.</p>
<p>Anda akan melanjutkan ke tahap seleksi selanjutnya yaitu [[TahapSeleksiSelanjutnya]]. Kami akan menghubungi Anda kembali melalui email atau telepon dalam beberapa hari ke depan untuk memberikan detail lebih lanjut mengenai jadwal dan proses tahap lanjut.</p>
<p>Mohon untuk tetap memantau email dan siap sedia mengikuti tahapan berikutnya. Jika Anda memerlukan informasi tambahan atau memiliki pertanyaan, jangan ragu untuk menghubungi kami.</p>
<p>Terima kasih atas partisipasi Anda dalam proses seleksi ini, dan kami berharap dapat melihat Anda di tahap selanjutnya.</p>
<p>Hormat kami,</p>
<p>[[NamaPenanggungJawab]]<br>[[Perusahaan]]<br>[[NoTelpPenanggungJawab]]<br>[[EmailPenanggungJawab]]</p>";
                    break;

                case TemplateEmailListProsesEnum::PENJADWALAN_SELEKSI:
                    $subject = "Pemberitahuan Jadwal Seleksi";
                    $content = "<p>Kepada Yth. [[NamaPeserta]],</p>
<p>Terima kasih telah mengajukan lamaran untuk Program Magang di <strong>[[Perusahaan]]</strong>.</p>
<p>Dengan senang hati kami mengundang Anda untuk mengikuti proses seleksi selanjutnya yang akan diadakan sesuai dengan jadwal berikut:</p>
<p><strong>Waktu:</strong> [[MulaiSeleksi]] - [[SelesaiSeleksi]]<br><strong>Lokasi:</strong> [[AlamatPerusahaan]]<br><strong>Persiapan:</strong></p>
<ul>
<li>Bawa dokumen yang diperlukan.</li>
<li>Pastikan hadir 15 menit sebelum waktu yang ditentukan.</li>
</ul>
<p>Jika Anda memiliki pertanyaan atau ada hal yang perlu dikonfirmasi terkait jadwal ini, jangan ragu untuk menghubungi kami melalui [[EmailPenanggungJawab]] atau [[NoTelpPenanggungJawab]].</p>
<p>Kami berharap dapat bertemu dan mengenal Anda lebih lanjut.</p>
<p>Salam hangat,<br>[[NamaPenanggungJawab]]<br>[[Perusahaan]]<br>[[EmailPenanggungJawab]]</p>";
                    break;
                
                case TemplateEmailListProsesEnum::DITERIMA_MAGANG:
                    $subject = "Pemberitahuan Penerimaan Magang";
                    $content = "<p>Yth. [[NamaPeserta]],</p>
<p>Salam sejahtera,</p>
<p>Kami dengan senang hati menginformasikan bahwa Anda telah diterima untuk mengikuti program magang di <strong>[[Perusahaan]]</strong> pada posisi <strong>[[PosisiMagang]]</strong>. Setelah melalui proses seleksi yang ketat, kami sangat menghargai minat dan kemampuan yang Anda tunjukkan selama proses rekrutmen.</p>
<p>Berikut adalah beberapa detail terkait program magang Anda:</p>
<p><strong>Lokasi</strong>: [[AlamatPerusahaan]]<br><strong>Waktu Kerja</strong>: 08.30 sampai 17.30</p>
<p>Untuk memulai program magang ini, kami mohon agar Anda dapat hadir untuk pengarahan terkait tugas dan tanggung jawab Anda selama magang, serta hal-hal administratif lainnya.</p>
<p>Jika Anda memerlukan informasi tambahan, jangan ragu untuk menghubungi kami melalui email ini.</p>
<p>Kami sangat menantikan kontribusi positif Anda dalam tim dan berharap masa magang ini akan menjadi pengalaman yang berharga bagi Anda.</p>
<p>Terima kasih dan sampai jumpa!</p>
<p>Hormat kami,</p>
<p>[[NamaPenanggungJawab]]<br>[[NoTelpPenanggungJawab]]<br>[[EmailPenanggungJawab]]</p>";
                    break;

                case TemplateEmailListProsesEnum::TIDAK_LOLOS_SELEKSI:
                    $subject = "Pemberitahuan Tidak Lolos Seleksi";
                    $content = "<p>Halo [[NamaPeserta]],</p>
<p>Terima kasih atas minat dan partisipasi Anda dalam proses seleksi program magang di <strong>[[Perusahaan]]</strong>. Setelah melalui pertimbangan yang matang, kami ingin memberitahukan bahwa saat ini Anda belum berhasil lolos ke tahap selanjutnya.</p>
<p>Kami sangat menghargai usaha dan waktu yang Anda investasikan dalam mengikuti proses seleksi ini. Meskipun demikian, kami yakin bahwa dengan semangat dan kemampuan yang Anda miliki, Anda akan menemukan kesempatan yang sesuai di masa mendatang.</p>
<p>Jika ada kesempatan lain di masa depan, kami sangat terbuka untuk Anda mengikuti program magang kami kembali. Terima kasih sekali lagi atas ketertarikan Anda pada [[Perusahaan]].</p>
<p>Salam hangat,<br>[[NamaPenanggungJawab]]<br>[[Perusahaan]]<br>[[EmailPenanggungJawab]]</p>";
                    break;
                
                default:
                    $subject = "";
                    $content = "";
                    break;
            }

            $data[] = [
                'id_email_template' => Str::orderedUuid(),
                'proses' => $value,
                'id_industri' => $this->industri->id_industri,
                'subject_email' => $subject,
                'headline_email' => $subject,
                'content_email' => $content,
            ];
        }
        EmailTemplate::insert($data);
    }
}
