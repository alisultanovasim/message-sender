<?php

namespace App\Imports;

use App\TestMessage;
use Maatwebsite\Excel\Concerns\ToModel;

class TestMessageImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new TestMessage([
            'phone_number'=>$row[0]
        ]);
    }
}
