<?php

namespace App;

use App\Http\Resources\OrganizationResource;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Organization extends Model
{
    use Searchable;
    public $asYouType = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'organizations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $orgs = $this->toArray();

        return $orgs;
        // return OrganizationResource::collection($orgs);
    }

    public function director()
    {
        return $this->belongsToMany('App\Profile')->wherePivot('role', 'director');
    }

    public function poc()
    {
        return $this->belongsToMany('App\Profile')->wherePivot('role', 'poc');
    }

    public function people()
    {
        return $this->belongsToMany('App\Profile');
    }
}
