<?php

namespace App\Http\Requests;

use App\Enums\ClipStates;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PopularClipRequest extends FormRequest
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
            'per_page' => [
                'integer',
                'between:1,100',
            ],
            'after_date' => [
                'required',
                'date',
                'before:before_date',
            ],
            'before_date' => [
                'required',
                'date',
                'after:after_date',
            ],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'per_page' => $this->per_page ?? 50,
            'after_date' => $this->after_date ?? now()->subWeek(),
            'before_date' => $this->before_date ?? now(),
        ]);
    }
}
