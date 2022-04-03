<?php

namespace App\Http\Requests;

use App\Enums\ClipStates;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SearchClipRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'relations' => [
                'nullable',
                'array',
                Rule::in(['creator', 'game', 'event']),
            ],
            'states' => [
                'nullable',
                'array',
                Rule::in([
                    ClipStates::Active->value,
                    ClipStates::Reject->value,
                ]),
            ],
            'per_page' => [
                'integer',
                'between:1,100',
            ],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'per_page' => $this->per_page ?? 50,
        ]);
    }
}
