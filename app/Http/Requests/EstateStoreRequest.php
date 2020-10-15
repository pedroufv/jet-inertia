<?php

namespace App\Http\Requests;

class EstateStoreRequest extends EstateRequest
{
    /**
     * The key to be used for the view error bag.
     *
     * @var string
     */
    protected $errorBag = 'estateStore';
}
