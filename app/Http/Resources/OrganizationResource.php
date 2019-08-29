<?php

namespace App\Http\Resources;

use App\Profile;
use Illuminate\Http\Resources\Json\Resource;

class OrganizationResource extends Resource
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
            'logo' => $this->logo,
            'name' => $this->name,
            'address' => $this->address,
            'country' => $this->country,
            'description' => $this->description,
            'phone' => $this->phone,
            'email' => $this->email,
            'website' => $this->website,
            'size_range' => $this->size_range,
            'legal_entity_type' => $this->legal_entity_type,
            'summary_of_needs' => $this->summary_of_needs,
            'audience' => $this->audience,
            'inception_date' => $this->inception_date,
            'target_locations' => $this->target_locations,
            'sector' => $this->sector,
            'services' => $this->services,
            'facebook_profile' => $this->facebook_profile,
            'twitter_profile' => $this->twitter_profile,
            'instagram_profile' => $this->instagram_profile,
            'funding_status' => $this->funding_status,
            'funding_type' => $this->funding_type,
            'operating_language' => $this->operating_language,
            'method_of_collection' => $this->method_of_collection,
            'director' => $this->director,
            'poc' => $this->poc,
            'approved' => $this->approved,
            //'director' => new ProfileResource($this->whenLoaded(Profile::findOrFail($this->director->id))),
            //'poc' => new ProfileResource($this->whenLoaded('poc')),
        ];
    }
}
