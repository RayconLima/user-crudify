<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Config;

class MinioHelper
{
    public static function generateMinioUrl($path)
    {
        $minioUrl = Config::get('filesystems.disks.s3.url');
        return "{$minioUrl}/{$path}";
    }
}