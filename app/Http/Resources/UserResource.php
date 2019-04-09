<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserResource extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'first_name' => $this->profile->first_name,
            'last_name' => $this->profile->last_name,
            'gender' => $this->profile->gender,
            'date_of_birth' => $this->profile->date_of_birth,
            'contact_email' => $this->profile->contact_email,
            'avatar' => $this->profile->avatar,
            'facebook_profile' => $this->profile->facebook_profile,
            'twitter_profile' => $this->profile->twitter_profile,
            'instagram_profile' => $this->profile->instagram_profile,
            'organizations' => [
                OrganiationResource::collection($this->whenLoaded('organizations')),
                'role' => 'Test',
            ],
        ];
    }
}
