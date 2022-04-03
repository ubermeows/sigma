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
            'sort' => [
                'string',
                Rule::in([
                    'duration',
                    'views',
                    'freshed_at', 
                    'published_at', 
                    'created_at',
                ]),
            ],
            'order' => [
                'string',
                Rule::in(['desc', 'asc']),
            ],
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
            'after_date' => [
                'nullable',
                'date',
                'exclude_unless:before_date,false',
                'before:before_date',
            ],
            'before_date' => [
                'nullable',
                'date',
                'exclude_unless:after_date,false',
                'after:after_date',
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
            'sort' => $this->sort ?? 'created_at',
            'order' => $this->order ?? 'asc',
            'per_page' => $this->per_page ?? 50,
        ]);
    }
}
