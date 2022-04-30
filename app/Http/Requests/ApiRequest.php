<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ApiRequest extends FormRequest
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
            ],
            'order' => [
                'string',
                Rule::in(['desc', 'asc']),
            ],
            'random' => [
                'nullable',
                'boolean',
            ],
            'relations' => [
                'nullable',
                'array',
            ],
            'states' => [
                'nullable',
                'array',
            ],
            'per_page' => [
                'integer',
                'between:1,100',
            ],
        ];
    }

    protected function prepareForValidation()
    {
        $closure = fn($item) => $item ? explode(',', $item) : null;

        $this->merge([
            'sort' => $this->sort ?? 'created_at',
            'order' => $this->order ?? 'asc',
            'states' => $closure($this->states),
            'relations' => $closure($this->relations),
            'per_page' => $this->per_page ?? 50,
            'random' => (bool) $this->random ?? false,
        ]);
    }
}
