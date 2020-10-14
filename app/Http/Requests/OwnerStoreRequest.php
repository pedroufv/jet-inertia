<?php

namespace App\Http\Requests;

class OwnerStoreRequest extends OwnerRequest
{
    /**
     * The key to be used for the view error bag.
     *
     * @var string
     */
    protected $errorBag = 'ownerStore';
}
