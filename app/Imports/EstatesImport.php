<?php

namespace App\Imports;

use App\Models\Estate;
use Maatwebsite\Excel\Concerns\ToModel;

class EstatesImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return Estate|null
     */
    public function model(array $row)
    {
        return new Estate([
            'state' => $row[0],
            'city' => $row[1],
            'neighborhood' => $row[2],
            'street' => $row[3],
            'number' => $row[4],
            'details' => $row[5],
        ]);
    }
}
