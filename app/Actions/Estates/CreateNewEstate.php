<?php

namespace App\Actions\Estates;

use App\Models\Estate;

class CreateNewEstate
{
    /**
     * @param array $data
     * @return Estate|\Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        return Estate::create($data);
    }
}
