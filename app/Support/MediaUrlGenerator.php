<?php

namespace App\Support;

use DateTimeInterface;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\Support\UrlGenerator\BaseUrlGenerator;

class MediaUrlGenerator extends BaseUrlGenerator
{
    public function getUrl(): string
    {
        if ($this->getDiskName() == 'local') {
            $pathRelativeToRoot = $this->getPathRelativeToRoot();

            if (Str::contains($pathRelativeToRoot, 'conversions')) {
                [$mediaId, $conversions, $mediaName] = explode('/', $pathRelativeToRoot);

                $url = URL::temporarySignedRoute('storage.local.conversions.show', now()->addMinutes(15), [
                    'media' => $mediaId,
                    'fileName' => $mediaName,
                ]);
            } else {
                [$mediaId, $mediaName] = explode('/', $pathRelativeToRoot);

                $url = URL::temporarySignedRoute('storage.local.show', now()->addMinutes(15), [
                    'media' => $mediaId,
                    'fileName' => $mediaName,
                ]);
            }
        } else {
            $url = $this->versionUrl($this->getDisk()->url($this->getPathRelativeToRoot()));
        }

        return $url;
    }

    public function getPath(): string
    {
        return $this->getRootOfDisk().$this->getPathRelativeToRoot();
    }

    public function getTemporaryUrl(DateTimeInterface $expiration, array $options = []): string
    {
        return $this->getDisk()->temporaryUrl($this->getPathRelativeToRoot(), $expiration, $options);
    }

    public function getResponsiveImagesDirectoryUrl(): string
    {
        $base = Str::finish($this->getBaseMediaDirectoryUrl(), '/');

        $path = $this->pathGenerator->getPathForResponsiveImages($this->media);

        return Str::finish(url($base.$path), '/');
    }

    public function getBaseMediaDirectoryUrl(): string
    {
        return $this->getDisk()->url('/');
    }

    protected function getRootOfDisk(): string
    {
        return $this->getDisk()->path('/');
    }
}
