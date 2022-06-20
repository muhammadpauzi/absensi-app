<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait useUniqueValidation
{
    /**
     * return true if unique (valid)
     * @return bool
     */
    protected function isUniqueOnLocal(string $key = '', array $data): bool
    {
        $dataOfKey = array_map(function ($d) use ($key) {
            return trim($d[$key]);
        }, $data);
        $uniqueData = array_unique($dataOfKey);

        return count($dataOfKey) === count($uniqueData);
    }

    /**
     * return true if unique (valid)
     * @return bool
     */
    protected function isUniqueOnDatabase(Collection|Model $originalData, array $data, string $key, $model): bool
    {
        if ($originalData[$key] === trim($data[$key]))
            return true;

        if (!$model::where($key, $data[$key])->first())
            return true;

        return false;
    }
}
