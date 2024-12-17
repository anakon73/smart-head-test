<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'genres' => 'array|nullable',
            'poster' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
