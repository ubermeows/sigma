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
                Rule::in([
                    'duration',
                    'views',
                    'freshed_at', 
                    'published_at', 
                    'created_at',
                ]),
            ],
            'order' => [
                Rule::in(['desc', 'asc']),
            ],
            'creator' => [
                'nullable',
                'string',
            ],
            'game' => [
                'nullable',
                'string',
            ],
            'event' => [
                'nullable',
                'string',
            ],
            'random' => [
                'nullable',
                'boolean',
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
        ];
    }
}
