<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait UploadLogoImage
{
    protected function uploadeLogoImage(Request $request)
    {
        if (!$request->hasFile('logo_image')) {
            return;
        }
        $file = $request->file('logo_image');
        $fileName = $file->getClientOriginalName();
        $path = $file->storeAs('Categories_logo/' . $request->name, $fileName, ['disk' => 'uploads']);
        return $path;
    }
    protected function uploadeImages(Request $request)
    {
        if (!$request->hasFile('cover_images')) {
            return;
        }

        $files = $request->file('cover_images');

        // لو مش array خليها array
        if (!is_array($files)) {
            $files = [$files];
        }

        $paths = [];

        foreach ($files as $file) {
            $fileName = $file->getClientOriginalName();
            $path = $file->storeAs('Categories_cover/' . $request->name, $fileName, ['disk' => 'uploads']);
            $paths[] = $path;
        }

        return implode(',', $paths);
    }
}