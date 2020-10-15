<?php

namespace App\Http\Requests;

class OwnerUpdateRequest extends OwnerRequest
{
    public function rules()
    {
        $owner = $this->route('owner');

        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:owners,email,'.$owner->id],
            'type' => ['required'],
            'identifier' => ['required', 'string'],
        ];
    }
}
