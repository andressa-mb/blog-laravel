<?php

namespace App\Models\Traits;

trait ResolveTable
{

    public function resolveModelTableName(): string {
        return $this->table;
    }

    public function resolveTableColumns(): array {
        return $this->fillable;
    }

}
