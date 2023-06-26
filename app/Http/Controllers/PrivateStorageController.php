<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PrivateStorageController
{
    public function showOriginal(Request $request, string $media, string $fileName)
    {
        if (is_numeric($media)) {
            $model = Media::query()->find($media);
        } else {
            $model = null;
        }

        if ($model) {
            $path = "{$model->getKey()}/$fileName";
            $disk = $model->disk;
        } else {
            $path = "$media/$fileName";
            $disk = config('media-library.disk_name');
        }

        if (! Storage::disk($disk)->exists($path)) {
            abort(404);
        }

        if ($request->input('download')) {
            return Storage::disk($model->disk)->download($path);
        }

        return Storage::disk($disk)->response($path);
    }

    public function showConversion(Request $request, string $media, string $fileName)
    {
        if (is_numeric($media)) {
            $model = Media::query()->find($media);
        } else {
            $model = null;
        }

        if ($model) {
            $path = "{$model->getKey()}/conversions/$fileName";
            $disk = $model->disk;
        } else {
            $path = "$media/conversions/$fileName";
            $disk = config('media-library.disk_name');
        }

        if (! Storage::disk($disk)->exists($path)) {
            abort(404);
        }

        if ($request->input('download')) {
            return Storage::disk($disk)->download($path);
        }

        return Storage::disk($disk)->response($path);
    }
}
