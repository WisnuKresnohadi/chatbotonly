<?php 

namespace App\Enums;

class LogbookDailyEmot
{
    use EnumTrait;

    const FRUSTASI = 1;
    const SEDIH = 2;
    const BIASA = 3;
    const HAPPY = 4;
    const LOVE = 5;

    public static function getWithEmot($status = null)
    {
        $data = [
            self::FRUSTASI => ['title' => 'Frustasi', 'image' => asset('assets/images/kyaa.png')],
            self::SEDIH => ['title' => 'Sedih', 'image' => asset('assets/images/sad.png')],
            self::BIASA => ['title' => 'Biasa Aja', 'image' => asset('assets/images/jutek.png')],
            self::HAPPY => ['title' => 'Happy', 'image' => asset('assets/images/smile.png')],
            self::LOVE => ['title' => 'Senang Sekali', 'image' => asset('assets/images/love.png')]
        ];

        if (isset($status)) return $data[$status];

        return $data;
    }
}