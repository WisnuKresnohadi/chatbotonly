<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Seleksi;
use App\Mail\MailContainer;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use App\Models\PegawaiIndustri;
use App\Models\PendaftaranMagang;
use App\Models\SendedEmailIndustri;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Enums\PendaftaranMagangStatusEnum;
use App\Enums\TemplateEmailListProsesEnum;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendMailIndustri implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $valid_step;
    /**
     * Create a new job instance.
     * @param User $from
     * @param $proses lolos_seleksi|penjadwalan_seleksi|diterima_magang|tidak_lolos_seleksi
     * @param $id_pendaftaran
     */
    public function __construct(
        public User $from,
        public $proses, 
        public $id_pendaftaran
    ){
        $this->valid_step = [
            PendaftaranMagangStatusEnum::APPROVED_BY_LKM => -1,
            PendaftaranMagangStatusEnum::SELEKSI_TAHAP_1 => 0,
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_1 => 1,
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_2 => 2,
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_3 => 3,
        ];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $pegawaiIndustri = PegawaiIndustri::where('id_user', $this->from->id)->first();
        $pendaftaran = PendaftaranMagang::select(
            'mahasiswa.namamhs', 'mahasiswa.nim', 'mahasiswa.emailmhs', 'users.id', 'pendaftaran_magang.current_step', 'lowongan_magang.intern_position', 
            'lowongan_magang.durasimagang', 'industri.namaindustri', 'industri.notelpon as notelponindustri', 'industri.alamatindustri',
            'industri.email as emailindustri', 'pegawai_industri.namapeg', 'pegawai_industri.jabatan as jabatanpeg', 'pegawai_industri.emailpeg',
            'pegawai_industri.nohppeg', 'lowongan_magang.tahapan_seleksi'
        )
        ->join('mahasiswa', 'mahasiswa.nim', 'pendaftaran_magang.nim')
        ->join('users', 'users.id', 'mahasiswa.id_user')
        ->join('lowongan_magang', 'lowongan_magang.id_lowongan', 'pendaftaran_magang.id_lowongan')
        ->join('industri', 'industri.id_industri', 'lowongan_magang.id_industri')
        ->join('pegawai_industri', 'pegawai_industri.id_peg_industri', 'industri.penanggung_jawab')
        ->whereIn('id_pendaftaran', is_array($this->id_pendaftaran) ? $this->id_pendaftaran : [$this->id_pendaftaran])->get();

        $templateEmail = new TemplateEmailListProsesEnum($this->proses);
        $templateEmail->getEmailTemplate($pegawaiIndustri->id_industri);
        $listTag = $templateEmail->getListTag($this->proses);
        $templateEmail = collect($templateEmail->data)->first();

        foreach ($pendaftaran as $key => $value) {
            $result = self::mappingData($value, $listTag, $templateEmail['template']['content']);
    
            SendedEmailIndustri::create([
                'id_industri' => $pegawaiIndustri->id_industri,
                'id_email_template' => $templateEmail['template']['id_template'],
                'sender_id' => $this->from->id,
                'sender' => $this->from->name,
                'id_send_to' => $value->id,
                'send_to' => $value->namamhs,
                'subject' => $templateEmail['template']['subject'],
                'proses' => $this->proses,
                'content' => $templateEmail['template']['content'],
            ]);
    
            dispatch(new SendMailJob($value->emailmhs, new MailContainer($templateEmail['template']['subject'], $value->namamhs, $value->namaindustri, $result)));
        }
    }

    private function mappingData(PendaftaranMagang $pendaftaran, $listTag, $dataTemplate)
    {
        $arraySearch = [];
        $arrayReplace = [];
        foreach ($listTag as $key => $value) {
            $arraySearch[] = $value['shortCode'];
            if ($value['columnName'] == 'current_step') {
                $pickStatus = $this->valid_step[$pendaftaran->current_step];
                if ($value['shortCode'] == '[[TahapSeleksi]]') $pickStatus = $pickStatus - 1;

                $pickStatus = array_search($pickStatus, $this->valid_step);
                $status = PendaftaranMagangStatusEnum::getWithLabel($pickStatus)['title'];

                $arrayReplace[] = $status;
            } else {
                if (in_array($value['columnName'], ['start_date', 'end_date'])) {
                    $step = $this->valid_step[$pendaftaran->current_step] + 1;
                    $jadwal = Seleksi::where('id_pendaftaran', $this->id_pendaftaran)->where('tahapan_seleksi', $step)->first();

                    $arrayReplace[] = $jadwal->{$value['columnName']};
                } else {
                    $arrayReplace[] = $pendaftaran->{$value['columnName']};
                }
            }
        }

        $result = str_replace($arraySearch, $arrayReplace, $dataTemplate);
        return $result;
    }
}
