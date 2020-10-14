<?php

namespace App\Actions\Owners;

use App\Models\Owner;

class CreateNewOwner
{
    /**
     * @param array $data
     * @return Owner|\Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        return Owner::create($data);
    }
}
