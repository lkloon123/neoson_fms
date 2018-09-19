<?php

namespace App\Api\V1\Requests;

class CreateMinerSummaryRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'algo' => 'required',
            'gpu_count' => 'required|integer',
            'hashrate' => 'required',
            'accepted_hash' => 'required|integer',
            'rejected_hash' => 'required|integer',
            'up_time' => 'required|integer',
            'api_token' => 'required'
        ];
    }
}