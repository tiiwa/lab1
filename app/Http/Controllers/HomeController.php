<?php

namespace App\Http\Controllers;

use App\Enums\ImpactAreaEnum;
use App\Enums\IndustryEnum;

class HomeController extends Controller
{
    /**
     * Route to home view.
     */
    public function home()
    {
        $data = [
            'industry' => IndustryEnum::getValues(),
            'impact_area' => ImpactAreaEnum::getValues()
        ];

        return view('home', compact('data'));
    }

    /**
     * Content for home page.
     */
    public function index()
    {
    }
}
