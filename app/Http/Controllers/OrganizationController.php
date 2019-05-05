<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrganizationResource;
use App\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
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

    public function search(Request $request)
    {
        $orgs = Organization::search($request->search)->get();

        return OrganizationResource::collection($orgs);
    }
}
