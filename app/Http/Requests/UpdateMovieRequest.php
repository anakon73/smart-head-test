<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMovieRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'nullable|string|max:255',
            'poster' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'genres' => 'nullable|array',
            'genres.*' => 'nullable|string|exists:genres,name',
        ];
    }
}
