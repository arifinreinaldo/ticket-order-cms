<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class Util
{
    public static function storeFile($file, $location)
    {
        return $file->store(config('constant.' . $location), 'public');
    }

    public static function updateFile($oldPath, $file, $location)
    {
        self::deleteFile($oldPath);
        return $file->store(config('constant.' . $location), 'public');
    }

    public static function deleteFile($oldPath)
    {
        Storage::delete("public/" . $oldPath);
    }
}
