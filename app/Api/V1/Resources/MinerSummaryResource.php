<?php

namespace App\Api\V1\Resources;

/**
 * Class MinerSummary
 *
 * @mixin \App\Models\MinerSummary
 * */
class MinerSummaryResource extends BaseResource
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
            'hashrate' => (int)$this->hashrate,
            'accepted_hash' => (int)$this->accepted_hash,
            'rejected_hash' => (int)$this->rejected_hash,
            'created_at' => $this->created_at->timestamp
        ]);
    }
}