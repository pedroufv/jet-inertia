<?php

namespace App\Actions\Owners;

use App\Models\Owner;

class DeleteOwner
{
    /**
     * @param Owner $owner
     * @throws \Exception
     */
    public function delete(Owner $owner)
    {
        $owner->delete();
    }
}
