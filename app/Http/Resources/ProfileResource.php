<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ProfileResource extends Resource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'gender' => $this->gender,
            'date_of_birth' => $this->date_of_birth,
            'contact_email' => $this->contact_email,
            'avatar' => $this->avatar,
            'facebook_profile' => $this->facebook_profile,
            'twitter_profile' => $this->twitter_profile,
            'instagram_profile' => $this->instagram_profile,
        ];
    }
}
