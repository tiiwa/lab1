<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'profiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function directs()
    {
        return $this->belongsToMany('App\Organization')->wherePivot('role', 'director');
    }

    public function contacts()
    {
        return $this->belongsToMany('App\Organization')->wherePivot('role', 'poc');
    }

    public function organizations()
    {
        return $this->belongsToMany('App\Organization')->withPivot('role', 'meta');
    }
}
