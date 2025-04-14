<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Readed
{
    public function scopeIsReaded(Builder $builder, bool $isReaded = true): Builder{
        return $builder->where([$this->qualifyColumn('readed') => $isReaded]);
    }
}
