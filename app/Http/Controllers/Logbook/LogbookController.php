<?php

namespace App\Http\Controllers\Logbook;

use App\Enums\PendaftaranMagangStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\PendaftaranMagang;
use Illuminate\Http\Request;

class LogbookController extends Controller
{
    public function __construct()
    {
        //
    }

    protected function getPendaftaranMagang($additional = null)
    {
        $this->pendaftaran = PendaftaranMagang::join('mahasiswa', 'mahasiswa.nim', '=', 'pendaftaran_magang.nim')
        ->where('current_step', PendaftaranMagangStatusEnum::APPROVED_PENAWARAN);

        if ($additional != null) $this->pendaftaran = $additional($this->pendaftaran);

        $this->pendaftaran = $this->pendaftaran->get();
        return $this;
    }

    protected function getListMonth($format = null)
    {
        $this->list_month = [];
        for ($i = 1; $i <= 12; $i++) {
            $this->list_month[] = ($format == null) ? date('F', mktime(0, 0, 0, $i, 1)) : date($format, mktime(0, 0, 0, $i, 1));
        }
        return $this;
    }


}
