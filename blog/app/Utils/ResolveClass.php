<?php

namespace App\Utils;

trait ResolveClass
{
    public function resolve(): string {
        return get_class($this);
    }
}
