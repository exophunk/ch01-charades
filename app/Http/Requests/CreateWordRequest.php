<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateWordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'word' => [
                'required',
                'string',
                'max:255',
            ],
            'room_id' => [
                'required',
                'numeric',
                'exists:rooms,id',
            ],
        ];
    }
}
