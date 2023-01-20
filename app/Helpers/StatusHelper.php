<?php

namespace App\Helpers;

class StatusHelper
{
    public static function procurements($status)
    {
        switch ($status) {
            case 1:
                return 'Diterima';
                break;
            case 2:
                return 'Pengajuan';
                break;
            case 3:
                return 'Ditolak';
                break;
            default:
                return 'Tidak Diketahui';
                break;
        }
    }

    public static function rentals($status)
    {
        switch ($status) {
            case 1:
                return [
                    'message' => 'Diterima',
                    'class' => 'success',
                ];
                break;
            case 2:
                return [
                    'message' => 'Pengajuan',
                    'class' => 'info',
                ];
                break;
            case 3:
                return [
                    'message' => 'Ditolak',
                    'class' => 'danger',
                ];
                break;
            default:
                return [
                    'message' => 'Tidak diketahui',
                    'class' => 'warning',
                ];
                break;
        }
    }

    public static function exterminate($status)
    {
        switch ($status) {
            case 1:
                return [
                    'message' => 'Diterima',
                    'class' => 'success',
                ];
                break;
            case 2:
                return [
                    'message' => 'Pending',
                    'class' => 'warning',
                ];
                break;
            case 3:
                return [
                    'message' => 'Ditolak',
                    'class' => 'danger',
                ];
                break;
            default:
                return [
                    'message' => 'Tidak diketahui',
                    'class' => 'warning',
                ];
                break;
        }
    }

    public static function consumables($status)
    {
        switch ($status) {
            case 1:
                return [
                    'message' => 'Diterima',
                    'class' => 'success',
                ];
                break;
            case 2:
                return [
                    'message' => 'Pending',
                    'class' => 'warning',
                ];
                break;
            case 3:
                return [
                    'message' => 'Ditolak',
                    'class' => 'danger',
                ];
                break;
            default:
                return [
                    'message' => 'Tidak diketahui',
                    'class' => 'warning',
                ];
                break;
        }
    }
}
