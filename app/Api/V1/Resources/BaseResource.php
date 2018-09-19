<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Api\V1\Resources;

use Config;
use Illuminate\Http\Resources\Json\Resource;

class BaseResource extends Resource
{
    protected function dateTimeData()
    {
        $res = [
            'created_at' => $this->created_at !== null ? $this->created_at->format(Config::get('app.datetime_format')) : null,
            'updated_at' => $this->updated_at !== null ? $this->updated_at->format(Config::get('app.datetime_format')) : null,
            'deleted_at' => $this->deleted_at !== null ? $this->deleted_at->format(Config::get('app.datetime_format')) : null,
        ];

        if ($this->deleted_at === null)
            return array_except($res, 'deleted_at');

        return $res;
    }
}