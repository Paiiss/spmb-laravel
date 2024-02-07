<?php

namespace App\Helper;

class StatusHelper
{
    public static function getStatus($status): string
    {
        switch ($status) {
            case 'waiting':
                return 'Menunggu';
            case 'submitted':
                return 'Mengumpulkan';
            case 'approved':
                return 'Disetujui';
            case 'rejected':
                return 'Ditolak';
            default:
                return $status;
        }
    }
}
