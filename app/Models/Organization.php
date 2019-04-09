<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
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
