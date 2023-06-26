<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;
use Spatie\MediaLibrary\Support\UrlGenerator\UrlGeneratorFactory;
use stdClass;

class Media extends BaseMedia
{
    private static array $generalFormats = [
        [
            'mime_type' => 'application/pdf',
            'name' => 'PDF',
            'icon' => 'fas fa-file-pdf',
            'is_image' => false,
        ],
        [
            'mime_type' => 'application/zip',
            'name' => 'Zip',
            'icon' => 'fas fa-file-archive',
            'is_image' => false,
        ],
        [
            'mime_type' => 'application/x-7z-compressed',
            'name' => '7zip',
            'icon' => 'fas fa-archive',
            'is_image' => false,
        ],
        [
            'mime_type' => 'application/msword',
            'name' => 'Ms Word',
            'icon' => 'fas fa-file-word',
            'is_image' => false,
        ],
        [
            'mime_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'name' => 'Ms Word',
            'icon' => 'fas fa-file-word',
            'is_image' => false,
        ],
        [
            'mime_type' => 'application/vnd.ms-excel',
            'name' => 'Excel',
            'icon' => 'fas fa-file-excel',
            'is_image' => false,
        ],
        [
            'mime_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'name' => 'Excel',
            'icon' => 'fas fa-file-excel',
            'is_image' => false,
        ],
        [
            'mime_type' => 'image/*',
            'name' => 'Image',
            'icon' => 'fas fa-image',
            'is_image' => true,
        ],
        [
            'mime_type' => 'video/*',
            'name' => 'Image',
            'icon' => 'fas fa-video',
            'is_image' => false,
        ],
    ];

    public function getSizeForHumansAttribute(): string
    {
        $bytes = $this->size;

        $units = ['b', 'Kb', 'MB', 'GB', 'TB', 'PB'];

        for ($i=0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . $units[$i];
    }

    public function getFileTypeAttribute(): object
    {
        $result = collect(self::$generalFormats)
            ->filter(function ($format) {
                return Str::is($format, $this->mime_type);
            })
            ->map(function ($format) {
                $obj = new stdClass();
                $obj->mime_type = $format['mime_type'];
                $obj->name = $format['name'];
                $obj->icon = $format['icon'];
                $obj->is_image = $format['is_image'];

                return $obj;
            })
            ->first();

        if (! $result) {
            $result = new stdClass();
            $result->mime_type = null;
            $result->name = 'File';
            $result->icon = 'fas fa-file';
            $result->is_image = false;
        }

        return $result;
    }

    public function getFormattedFileNameAttribute(): string
    {
        return Str::of($this->file_name)
            ->trim()
            ->replace('-', ' ')
            ->replace('_', ' ')
            ->replace('.', ' ')
            ->substr(0, strrpos($this->file_name, '.'))
            ->title();
    }

    public function getDownloadFullUrl(string $conversionName = ''): string
    {
        return url($this->getDownloadUrl($conversionName));
    }

    public function getDownloadUrl(string $conversionName = ''): string
    {
        $urlGenerator = UrlGeneratorFactory::createForMedia($this, $conversionName);

        return $urlGenerator->getUrl(true);
    }
}
