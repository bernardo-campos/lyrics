<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'query' => urldecode($this->input('query')),
            'artists' => array_filter(explode(',', $this->input('artists'))),
            'albums' => array_filter(explode(',', $this->input('albums'))),
        ]);
    }

    public function rules(): array
    {
        return [
            'query' => 'nullable|string',
            'artists' => 'nullable|array',
            'artists.*' => 'integer',
            'albums' => 'nullable|array',
            'albums.*' => 'integer',
        ];
    }
}
