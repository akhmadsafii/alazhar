<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;

class UploadHelper
{
    public static function upload_image($request, $data, $name)
    {
        $data[$name] = $request->file('file')->store('images', 'public');
        return $data;
    }

    public static function show_image($file)
    {
        // File::link(
        //     storage_path('app/public'),
        //     public_path('storage')
        // );
        return asset('storage/' . $file);
    }

    public static function show_sensitive_image($file)
    {
        $resp_image = storage_path($file);
        return response()->file($resp_image);
    }
}
