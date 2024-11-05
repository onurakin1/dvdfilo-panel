<?php

namespace App\Repositories\Eloquent\Interfaces;


use Illuminate\Support\Collection;

interface SettingRepositoryInterface
{
    public function getForGroup(string $group_name): Collection;

    public function updateKeyValue(array $attributes): bool;
}
