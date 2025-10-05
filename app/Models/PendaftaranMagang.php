<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PendaftaranMagang extends Model
{
    use HasUuids;

    protected $table = 'pendaftaran_magang';
    protected $guarded = [];

    public $timestamps = false;
    protected $primaryKey = 'id_pendaftaran';

    protected $casts = ['tanggaldaftar' => 'datetime'];


    /**
     * Set value current step first.
     */
    public function saveHistoryApproval($id_user = null, $name = null)
    {
        $user = auth()->user();
        $history = json_decode($this->history_approval, true) ?? [];
        $history_approval = [
            'id_user' => $id_user ?? $user->id ?? 'By System',
            'name' => $name ?? $user->name ?? 'By System',
            'time' => now()->format('Y-m-d H:i:s'),
            'status' => $this->current_step
        ];
        array_push($history, $history_approval);
        $this->history_approval = json_encode($history);
        return $this;
    }

    public function lowongan_magang()
    {
        return $this->belongsTo(LowonganMagang::class, 'id_lowongan');
    }
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim');
    }
    public function tahun_akademik()
    {
        return $this->belongsTo(TahunAkademik::class, 'id_year_akademik');
    }
    public function mahasiswa_magang()
    {
        return $this->hasOne(MhsMagang::class, 'id_pendaftaran');
    }

    public function seleksi_lowongan()
    {
        return $this->hasMany(Seleksi::class, 'id_pendaftaran', 'id_pendaftaran');
    }

    public function bidangPekerjaanIndustri()
    {
        return $this->hasManyThrough(
            BidangPekerjaanIndustri::class,
            LowonganMagang::class,
            'id_lowongan',       // Foreign key di tabel LowonganMagang
            'id_bidang_pekerjaan_industri',                // Primary key di tabel BidangPekerjaanIndustri
            'id_lowongan',       // Foreign key di tabel PendaftaranMagang
            'intern_position'    // Foreign key di tabel LowonganMagang
        );
    }
}
