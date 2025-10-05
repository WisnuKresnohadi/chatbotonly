<?php

namespace App\Enums;

class BerkasAkhirMagangStatus 
{
    use EnumTrait;

    const PENDING = 'pending';
    const APPROVED = 'approved';
    const REJECTED = 'rejected';
    
    public static function getWithLabel($status = null)
    {
        $data = [
            self::PENDING => ['title' => 'Menunggu Diverifikasi', 'color' => 'warning', 'icon' => 'info-circle'],
            self::APPROVED => ['title' => 'Lengkap', 'color' => 'success', 'icon' => 'circle-check'],
            self::REJECTED => ['title' => 'Tidak Lengkap', 'color' => 'danger', 'icon' => 'circle-x']
        ];

        if ($status) return $data[$status];

        return $data;
    }
}