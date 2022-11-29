<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestMessage extends Model
{
    use SoftDeletes;
    protected $hidden='id';
    protected $table='test_messages';
    protected $fillable=[
      'phone_number'
    ];
}
