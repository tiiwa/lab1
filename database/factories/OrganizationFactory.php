<?php

use App\Enums\ImpactAreaEnum;
use App\Enums\IndustryEnum;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$data = shell_exec('node resources/js/services/getCountries.js names');
$this->countries = (array) json_decode($data);

$this->industry = IndustryEnum::getValues();
$this->impact_area = ImpactAreaEnum::getValues();

$factory->define(App\Organization::class, function (Faker $faker) {
    $company = $faker->company;

    return [
        'name' => $company,
        'description' => $faker->realText($maxNbChars = 200, $indexSize = 2),
        'phone' => $faker->phoneNumber,
        'email' => $faker->unique()->companyEmail,
        'website' => $faker->domainName,
        'target_locations' => $faker->address,
        'size_range' => $faker->randomElement($array = ['1-5', '5-15', '15-50', '50-500', '500-1000', '1000+']),
        'legal_entity_type' => $faker->randomElement($array = ['Non-Profit', 'For-Profit', 'Charitable', 'Trust', 'Foundation']),
        'summary_of_needs' => $faker->realText($maxNbChars = 200, $indexSize = 2),
        'audience' => $faker->randomElement($array = ['Other Businesses', 'Consumer classes', 'Government/Policy', 'Underserved']),
        'inception_date' => $faker->name,
        'industry' => $faker->randomElement($this->industry),
        'impact_area' => $faker->randomElement($this->impact_area),
        'facebook_profile' => 'https://www.facebook.com/'.$company,
        'twitter_profile' => 'https://twitter.com/'.$company,
        'instagram_profile' => 'https://instagram.com/'.$company,
        'funding_status' => $faker->randomElement($array = ['Fundraising', 'Fully Funded', 'Private Equity', 'Public']),
        'funding_type' => $faker->randomElement($array = ['Grants', 'Donations', 'Debt']),
        'operating_language' => $faker->randomElement($array = ['English ', 'French', 'Swahili']),
        'method_of_collection' => $faker->randomElement($array = ['Personal Contact ', 'Company Hub', 'Online Resource']),
        'approved' => $faker->randomElement($array = [true, false]),
        'address' => $faker->address,
        'country' => $faker->randomElement($array = $this->countries),
        'logo' => $faker->randomElement($array = [$faker->imageUrl(100, 100), null]),
    ];
});
