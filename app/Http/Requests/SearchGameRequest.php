<?php

namespace App\Http\Requests;

use App\Enums\ClipStates;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SearchGameRequest extends FormRequest
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
                Rule::in(['active_clips_count', 'published_at']),
            ],
            'order' => [
                'string',
                Rule::in(['desc', 'asc']),
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
            'sort' => $this->sort ?? 'published_at',
            'order' => $this->order ?? 'asc',
            'per_page' => $this->per_page ?? 50,
        ]);
    }
}
