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
        'logo' => 'nullable',
        'location' => 'required',
        'description' => 'required',
        'phone' => 'nullable',
        'email' => 'nullable|unique:organizations',
        'website' => 'nullable',
        'size_range' => 'nullable',
        'legal_entity_type' => 'nullable',
        'summary_of_needs' => 'nullable',
        'audience' => 'nullable',
        'inception_date' => 'nullable',
        'target_locations' => 'nullable',
        'industry' => 'nullable',
        'impact_area' => 'nullable',
        'facebook_profile' => 'nullable',
        'twitter_profile' => 'nullable',
        'instagram_profile' => 'nullable',
        'funding_status' => 'nullable',
        'funding_type' => 'nullable',
        'operating_language' => 'nullable',
        'method_of_collection' => 'nullable',
        'director_first_name' => 'nullable',
        'director_last_name' => 'nullable',
        'director_email' => 'nullable|email|unique:profiles,contact_email',
        'poc_first_name' => 'nullable',
        'poc_last_name' => 'nullable',
        'poc_email' => 'required|email|unique:profiles,contact_email',
    ];

    public function index()
    {
        $orgs = Organization::latest()->paginate();

        return OrganizationResource::collection($orgs);
    }

    public function indexAll()
    {
        $orgs = Organization::withoutGlobalScopes()->latest()->paginate();

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
        $org = Organization::withoutGlobalScopes()->with(['director', 'poc'])->findOrFail($id);

        return new OrganizationResource($org);
    }

    public function search(Request $request)
    {
        $orgs = Organization::search($request->q)->get();

        return OrganizationResource::collection($orgs);
    }

    public function filter(Request $request)
    {
        $orgs = (new Organization())->newQuery();

        if ($request->has('searchFilter.country') && null != $request->input('searchFilter.country')) {
            $orgs->where('country', $request->input('searchFilter.country'));
        }

        if ($request->has('searchFilter.industry') && null != $request->input('searchFilter.industry')) {
            $orgs->where('industry', $request->input('searchFilter.industry'));
        }

        if ($request->has('searchFilter.impact_area') && null != $request->input('searchFilter.impact_area')) {
            $orgs->where('impact_area', $request->input('searchFilter.impact_area'));
        }

        return OrganizationResource::collection($orgs->get());
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
            'address' => $request->address,
            'country' => $request->country,
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
            'industry' => $request->industry,
            'impact_area' => $request->services,
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
    public function update(Request $request, $organization)
    {
        $validator = Validator::make($request->all(), $this->validationRules);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $organization->update($request->all());

        return response()->json([
            'message' => 'Organization updated!',
            'data' => new OrganizationResource($organization->load(['group', 'contents', 'events', 'logs'])),
        ]);
    }

    public function approveOrganization($id)
    {
        $org = Organization::withoutGlobalScopes()->findOrFail($id);
        $org->approved = true;
        $org->save();

        return response()->json(['message' => 'Organization approved!', 'data' => $org]);
    }

    public function disapproveOrganization($id)
    {
        $org = Organization::withoutGlobalScopes()->findOrFail($id);
        $org->approved = false;
        $org->save();

        return response()->json(['message' => 'Organization disapproved!', 'data' => $org]);
    }
}
