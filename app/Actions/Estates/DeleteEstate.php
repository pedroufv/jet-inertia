<?php

namespace App\Actions\Estates;

use App\Models\Estate;

class DeleteEstate
{
    /**
     * @param Estate $estate
     * @throws \Exception
     */
    public function delete(Estate $estate)
    {
        $estate->delete();
    }
}
