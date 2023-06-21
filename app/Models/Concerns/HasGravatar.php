<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $gravatar
 *
 * @mixin Model
 */
trait HasGravatar
{
    public function getGravatarAttribute(): string
    {
        $hash = md5(strtolower(trim($this->{$this->gravatarEmail()})));

        return "https://www.gravatar.com/avatar/{$hash}?d=mp&s=512";
    }

    protected function gravatarEmail(): string
    {
        return 'email';
    }
}
