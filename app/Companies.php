<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    protected $table="companies";

    public function logo()
    {
        return $this->hasOne(CompanyLogo::class,'id','c_logo');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
