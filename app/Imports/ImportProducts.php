<?php

namespace App\Imports;

use App\Models\Products;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportProducts implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Products([
            'cod' => $row[0],
            'brand' => $row[1],
            'name' => $row[2],
            'um' => $row[3],
        ]);
    }
}
