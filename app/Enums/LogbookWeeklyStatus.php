<?php 

namespace App\Enums;

class LogbookWeeklyStatus
{
    use EnumTrait;

    const NOT_YET_APPLIED = 0;
    const PENDING = 1;
    const APPROVED = 2;
    const REJECTED = 3;

    public static function getWithLabel($status = null)
    {
        $data = [
            self::NOT_YET_APPLIED => ['title' => 'Belum diajukan', 'color' => 'secondary'],
            self::PENDING => ['title' => 'Belum disetujui', 'color' => 'warning'],
            self::APPROVED => ['title' => 'Disetujui', 'color' => 'success'],
            self::REJECTED => ['title' => 'Ditolak', 'color' => 'danger'],
        ];

        if (isset($status)) return $data[$status];

        return $data;
    }
}