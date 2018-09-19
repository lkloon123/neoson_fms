<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Api\V1\Requests;

class UpdateUserRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'profile_img' => 'image',
            'name' => 'string',
        ];
    }
}
