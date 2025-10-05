<?php

namespace App\Enums;

use App\Models\EmailTemplate;

class TemplateEmailListProsesEnum
{
    use EnumTrait;

    const LOLOS_SELEKSI = 'lolos_seleksi';
    const PENJADWALAN_SELEKSI = 'penjadwalan_seleksi';
    const DITERIMA_MAGANG = 'diterima_magang';
    const TIDAK_LOLOS_SELEKSI = 'tidak_lolos_seleksi';

    public function __construct($proses = null)
    {
        if ($proses != null) {
            $this->data[] = ['proses' => $proses];
        } else {
            foreach (array_values(self::getConstants()) as $key => $value) {
                $this->data[] = ['proses' => $value];
            }
        }
    }

    public function __destruct() {
        return $this->data;
    }

    /**
     * Get list with label.
     * @return TemplateEmailListProsesEnum
     */
    public function getWithLabel()
    {
        foreach ($this->data as $key => $value) {
            $this->data[$key]['label'] = self::_getWithLabel($value['proses'])['title'];
        }

        return $this;
    }

    /**
     * Get email template.
     * @return TemplateEmailListProsesEnum
     */
    public function getEmailTemplate($id_industri) {
        $proses = collect($this->data)->pluck('proses')->toArray();
        $emailTemplate = EmailTemplate::where('id_industri', $id_industri)->whereIn('proses', $proses)->get();

        foreach ($this->data as $key => $value) {
            $email = $emailTemplate->where('proses', $value['proses'])->first();
            if ($email) {
                $this->data[$key]['template'] = [
                    'id_template' => $email->id_email_template,
                    'subject' => $email->subject_email,
                    'content' => $email->content_email
                ];
            }
        }

        return $this;
    }

    public static function _getWithLabel($proses = null)
    {
        $data = [
            self::LOLOS_SELEKSI => ['title' => 'Lolos Seleksi'],
            self::PENJADWALAN_SELEKSI => ['title' => 'Penjadwalan Seleksi'],
            self::DITERIMA_MAGANG => ['title' => 'Diterima Magang'],
            self::TIDAK_LOLOS_SELEKSI => ['title' => 'Tidak Lolos Seleksi']
        ];

        if ($proses != null) return $data[$proses];

        return $data;
    }

    public static function getListTag($proses = null)
    {
        $listTag = [
            ['title' => 'Nama Peserta', 'shortCode' => '[[NamaPeserta]]', 'columnName' => 'namamhs'],
            ['title' => 'NIM', 'shortCode' => '[[NIM]]', 'columnName' => 'nim'],
            ['title' => 'Posisi Magang', 'shortCode' => '[[PosisiMagang]]', 'columnName' => 'intern_position'],
            ['title' => 'Durasi Magang', 'shortCode' => '[[DurasiMagang]]', 'columnName' => 'durasimagang'],
            // profile perusahaan
            ['title' => 'Perusahaan', 'shortCode' => '[[Perusahaan]]', 'columnName' => 'namaindustri'],
            ['title' => 'Nomor Perusahaan', 'shortCode' => '[[NomorPerusahaan]]', 'columnName' => 'notelponindustri'],
            ['title' => 'Alamat Perusahaan', 'shortCode' => '[[AlamatPerusahaan]]', 'columnName' => 'alamatindustri'],
            ['title' => 'Email Perusahaan', 'shortCode' => '[[EmailPerusahaan]]', 'columnName' => 'emailindustri'],
            ['title' => 'Nama Penanggung Jawab', 'shortCode' => '[[NamaPenanggungJawab]]', 'columnName' => 'namapeg'],
            // ['title' => 'Jabatan Penanggung Jawab', 'shortCode' => '[[JabatanPenanggungJawab]]', 'columnName' => 'jabatanpeg'],
            ['title' => 'Email Penanggung Jawab', 'shortCode' => '[[EmailPenanggungJawab]]', 'columnName' => 'emailpeg'],
            ['title' => 'No Telp Penanggung Jawab', 'shortCode' => '[[NoTelpPenanggungJawab]]', 'columnName' => 'nohppeg'],
            // --------------------------------------------------------------
        ];
        if ($proses == self::LOLOS_SELEKSI) {
            $listTag[] = ['title' => 'Tahap Seleksi', 'shortCode' => '[[TahapSeleksi]]', 'columnName' => 'current_step'];
            $listTag[] = ['title' => 'Tahap Seleksi Selanjutnya', 'shortCode' => '[[TahapSeleksiSelanjutnya]]', 'columnName' => 'current_step'];
            
        } else if ($proses == self::PENJADWALAN_SELEKSI) {
            $listTag[] = ['title' => 'Mulai Seleksi', 'shortCode' => '[[MulaiSeleksi]]', 'columnName' => 'start_date'];
            $listTag[] = ['title' => 'Selesai Seleksi', 'shortCode' => '[[SelesaiSeleksi]]', 'columnName' => 'end_date'];
        } else if ($proses == self::DITERIMA_MAGANG) {
            
        } else if ($proses == self::TIDAK_LOLOS_SELEKSI) {
            
        }

        return $listTag;
    }
}