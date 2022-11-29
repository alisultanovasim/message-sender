<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyLogo extends Model
{
    use SoftDeletes;
    public function company()
    {
        return $this->belongsTo(Companies::class);
    }
}
