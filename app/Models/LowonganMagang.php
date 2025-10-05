<?php

namespace App\Models;

use App\Enums\PendaftaranMagangStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LowonganMagang extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'lowongan_magang';
    protected $guarded = [];
    protected $primaryKey = 'id_lowongan';
    protected $fillable = [
        'created_by',
        'id_jenismagang',
        'created_at',
        'intern_position',
        'durasimagang',
        'deskripsi',
        'requirements',
        'kuota',
        'benefitmagang',
        'startdate',
        'enddate',
        'tahapan_seleksi',
        'date_confirm_closing',
        'softskill',
        'applicant_status',
        'pelaksanaan',
        'jenjang',
        'keterampilan',
        'id_industri',
        'id_flow',
        'nominal_salary',
        'gender',
        'status',
        'alasantolak',
        'statusaprove',
        'status_user',
        'status_time',
        'lokasi',
        'id_year_akademik',
        'mulai_magang',
        'selesai_magang',
        'pembobotan',
        'pembobotan_user',
    ];
    protected $keyType = 'string';
    protected $casts = [
        'startdate' => 'datetime',
        'enddate' => 'datetime'
    ];
    const UPDATED_AT = null;
    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });

        static::saving(function ($model) {
            if (isset($model->jenjang_pendidikan)) unset($model->jenjang_pendidikan);
            if (isset($model->program_studi)) unset($model->program_studi);
            if (isset($model->kuota_terisi)) unset($model->kuota_terisi);
        });

        static::retrieved(function ($model) {
            $model->kuota_terisi = $model->total_pelamar()->where('current_step', PendaftaranMagangStatusEnum::APPROVED_PENAWARAN)->count();
        });
    }

    public function dataTambahan(string|array ...$typeGet)
    {
        $jenjang = get_object_vars(json_decode($this->jenjang));

        if (count(array_filter($typeGet, 'is_array')) === count($typeGet)) {
            $typeGet = array_merge(...array_values($typeGet));
        }

        foreach ($typeGet as $key => $value) {
            if ($value == 'jenjang_pendidikan') {
                $this->jenjang_pendidikan = array_keys($jenjang);
            } else if ($value == 'program_studi') {
                $this->program_studi = array_merge(...array_values($jenjang));
                $this->program_studi = ProgramStudi::whereIn('id_prodi', $this->program_studi)->get();
            }
        }

        return $this;
    }

    public function industri()
    {
        return $this->belongsTo(Industri::class, 'id_industri');
    }
    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademik::class, 'id_year_akademik');
    }
    public function jenisMagang()
    {
        return $this->belongsTo(JenisMagang::class, 'id_jenismagang');
    }
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'id_lokasi');
    }
    public function prodi()
    {
        return $this->belongsTo(ProgramStudi::class, 'id_prodi');
    }
    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'id_fakultas');
    }
    public function total_pelamar()
    {
        return $this->hasMany(PendaftaranMagang::class, 'id_lowongan');
    }
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim');
    }
    public function univ()
    {
        return $this->belongsTo(Universitas::class, 'id_univ');
    }
    public function seleksi_tahap()
    {
        return $this->hasMany(SeleksiTahap::class, 'id_lowongan', 'id_lowongan');
    }
    public function prodilowongan()
    {
        return $this->hasManyThrough(
            ProgramStudi::class,
            LowonganProdi::class,
            'lowongan_prodi_id',
            'id_lowongan',
            'id_prodi'
        );
    }
    public function jenis_magang()
    {
        return $this->belongsTo(JenisMagang::class, 'id_jenismagang');
    }
    public function pendaftaran()
    {
        return $this->hasMany(PendaftaranMagang::class, 'id_lowongan');
    }
    public function tahun_akademik(){
        return $this->belongsTo(TahunAkademik::class, 'id_year_akademik');
    }

    public function bidangPekerjaanIndustri() {
        return $this->belongsTo(BidangPekerjaanIndustri::class, 'intern_position');
    }
}
