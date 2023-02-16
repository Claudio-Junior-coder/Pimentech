<?php

namespace App\Imports;

use App\Models\Customers;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportCustomers implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Customers([
            //
            'cod' => $row[0],
            'name' => $row[1],
            'cnpj' => $row[2],
            'phone' => '(' . $row[3] . ') ' . $row[4],
            'city' => $row[5],
            'state' => $row[6],
        ]);
    }
}
