<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Api\V1\Resources;

/**
 * Class Software
 *
 * @mixin \App\Models\Software
 * */
class SoftwareResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'name' => $this->name,
            'exe_name' => $this->exe_name,
            'version' => $this->version,
            'github_link' => $this->github_link,
            'sha256_checksum' => $this->sha256_checksum,
        ], $this->dateTimeData());
    }
}