<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrganizationResource;
use App\Organization;

class HomeController extends Controller
{
    /**
     * Route to home view.
     */
    public function home()
    {
        return view('home');
    }

    /**
     * Content for home page.
     */
    public function index()
    {
        $orgs = Organization::latest()->paginate(10);

        return OrganizationResource::collection($orgs);
    }
}
