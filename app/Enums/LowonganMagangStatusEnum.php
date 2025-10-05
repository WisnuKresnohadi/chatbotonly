<?php 

namespace App\Enums;

class LowonganMagangStatusEnum
{
    use EnumTrait;

    const PENDING = 'tertunda';
    const APPROVED = 'diterima';
    const REJECTED = 'ditolak';
}