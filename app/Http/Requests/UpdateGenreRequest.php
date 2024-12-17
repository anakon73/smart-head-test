<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGenreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $genreId = $this->route('id');

        return [
            'name' => 'nullable|string|max:255|unique:genres,name,' . $genreId,
        ];
    }
}
