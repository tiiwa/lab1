<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrganizationResource;
use App\Organization;
use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class OrganizationController extends Controller
{
    protected $validationRules = [
        'name' => 'required',
        'logo' => 'nullable',
        'address' => 'required',
        'country' => 'required',
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
        'sector' => 'nullable',
        'services' => 'nullable',
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

    private function generateFileName(String $orgName, String $fileType)
    {
        // Replace white space and comma with underscore in organization name
        $orgName = preg_replace('/\s+/', '', $orgName);
        $orgName = str_replace(',', '', $orgName);

        // Generate file name
        $fileName = 'Logo_'.$orgName.date('_m-d-Y_hi').'.'.$fileType;

        return $fileName;
    }

    private function saveLogo(String $logoBase64, String $orgName)
    {
        $url = null;

        if (preg_match('/^data:image\/(\w+);base64,/', $logoBase64)) {
            // Seperate image data from image type
            list($fileMimeType, $data) = explode(';', $logoBase64);
            $data = substr($data, strpos($data, ',') + 1);
            $fileType = substr($fileMimeType, strpos($fileMimeType, '/') + 1);

            $data = base64_decode($data); // Decode image from base64
            $fileType = strtolower($fileType); // jpg, png, gif
            $fileName = $this->generateFileName($orgName, $fileType); // Generate filename

            // Store organization logo on disk
            Storage::put($fileName, $data);

            // Retrieve url to store in database
            $url = Storage::url($fileName);
        }

        return $url;
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

        // Attempt to store logo and get url
        $logoUrl = null;
        if (null != $request->logo) {
            $logoUrl = $this->saveLogo($request->logo, $request->name);
        }

        $organization = Organization::create([
            'name' => $request->name,
            'logo' => $logoUrl,
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
    public function update(Request $request, $organization)
    {
        $validator = Validator::make($request->all(), $this->validationRules);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $organization->update($request->all());

        return response()->json([
            'message' => 'Organization updated!',
            'data' => new OrganizationResource($device->load(['group', 'contents', 'events', 'logs'])),
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
