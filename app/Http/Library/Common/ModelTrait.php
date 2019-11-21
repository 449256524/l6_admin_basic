<?php


namespace App\Http\Library\Common;


trait ModelTrait
{
    public function getOne($params)
    {
        $query = static::query();

        if (isset($params['where'])) {
            $query->where($params['where']);
        }

        return $query->first();
    }
}
