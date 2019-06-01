<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrganizationResource;
use App\Organization;
use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrganizationController extends Controller
{
    protected $validationRules = [
        'name' => 'required',
        'location' => 'required',
        'description' => 'required',
        'phone' => 'sometimes',
        'email' => 'sometimes|unique:organizations',
        'website' => 'sometimes',
        'size_range' => 'sometimes',
        'legal_entity_type' => 'sometimes',
        'summary_of_needs' => 'sometimes',
        'audience' => 'sometimes',
        'inception_date' => 'sometimes',
        'target_locations' => 'sometimes',
        'sector' => 'sometimes',
        'services' => 'sometimes',
        'facebook_profile' => 'sometimes',
        'twitter_profile' => 'sometimes',
        'instagram_profile' => 'sometimes',
        'funding_status' => 'sometimes',
        'funding_type' => 'sometimes',
        'operating_language' => 'sometimes',
        'method_of_collection' => 'sometimes',
        'director_first_name' => 'sometimes',
        'director_last_name' => 'sometimes',
        'director_email' => 'sometimes|email|unique:profiles,contact_email',
        'poc_first_name' => 'sometimes',
        'poc_last_name' => 'sometimes',
        'poc_email' => 'required|email|unique:profiles,contact_email',
    ];

    public function index()
    {
        $orgs = Organization::latest()->paginate();

        return OrganizationResource::collection($orgs);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\User $user
     *
     * @return \App\Http\Resources\OrganizationResource
     */
    public function show($id)
    {
        $org = Organization::with(['director', 'poc'])->findOrFail($id);

        return new OrganizationResource($org);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \App\Http\Resources\OrganizationResource|\Illuminate\Support\MessageBag
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validationRules);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages()->first()], 422);
        }

        $poc = Profile::create([
            'first_name' => $request->poc_first_name,
            'last_name' => $request->poc_last_name,
            'contact_email' => $request->poc_email,
        ]);

        $director = Profile::create([
            'first_name' => $request->director_first_name,
            'last_name' => $request->director_last_name,
            'contact_email' => $request->director_email,
        ]);

        $organization = Organization::create([
            'name' => $request->name,
            'location' => $request->location,
            'description' => $request->description,
            'phone' => $request->phone,
            'email' => $request->email,
            'website' => $request->website,
            'size_range' => $request->size_range,
            'legal_entity_type' => $request->legal_entity_type,
            'summary_of_needs' => $request->summary_of_needs,
            'audience' => $request->audience,
            'inception_date' => $request->inception_date,
            'target_locations' => $request->target_locations,
            'sector' => $request->sector,
            'services' => $request->services,
            'facebook_profile' => $request->facebook_profile,
            'twitter_profile' => $request->twitter_profile,
            'instagram_profile' => $request->instagram_profile,
            'funding_status' => $request->funding_status,
            'funding_type' => $request->funding_type,
            'operating_language' => implode(',', $request->operating_language),
            'method_of_collection' => $request->method_of_collection,
        ]);

        $organization->director()->save($director, ['role' => 'director']);
        $organization->poc()->save($poc, ['role' => 'poc']);

        return response()->json(['message' => 'Organization created!', 'data' => $organization]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Organization        $device
     *
     * @return \App\Http\Resources\OrganizationResource|\Illuminate\Support\MessageBag
     */
    public function update(Request $request, $device)
    {
        $validator = Validator::make($request->all(), $this->validationRules);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $device->update($request->all());

        return response()->json([
            'message' => 'Organization updated!',
            'data' => new OrganizationResource($device->load(['group', 'contents', 'events', 'logs'])),
        ]);
    }
}
