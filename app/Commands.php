<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commands extends Model
{
    protected $table="commands";
    
    public function images()
    {
         return $this->hasMany(CommandImages::class, 'command_id', 'id');
    }
    public function videos()
    {
         return $this->hasMany(CommandVideos::class, 'command_id', 'id');
    }
    public function messages()
    {
         return $this->hasMany(CommandMessages::class, 'command_id', 'id');
    }
    public function addresses()
    {
         return $this->hasMany(CommandAddress::class, 'command_id', 'id');
    }
}
