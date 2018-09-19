<?php

namespace App\Api\V1\Resources;

use App\Models\User;
use Bouncer;

/**
 * Class User
 *
 * @mixin \App\Models\User
 * */
class UserResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $role = [];
        $thisUser = User::find($this->id);

        if (Bouncer::is($thisUser)->a('superuser')) {
            $role = [
                'role' => 'superuser'
            ];
        } else if (Bouncer::is($thisUser)->an('admin')) {
            $role = [
                'role' => 'admin'
            ];
        }

        return array_merge([
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'profile_img' => $this->profile_img ?: '/images/default-profile.png',
            'available' => $this->available === 1,
        ], $role, $this->dateTimeData());
    }
}
