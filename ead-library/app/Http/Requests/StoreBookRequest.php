<?php

namespace App\Http\Requests;

use App\Models\Book;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:150', Rule::unique('books', 'title')],
            'author' => ['required', 'string', 'max:120'],
            'category' => ['required', 'string', Rule::in(Book::categories())],
            'published_year' => ['required', 'integer', 'min:1900', 'max:' . now()->addYear()->year],
            'stock' => ['required', 'integer', 'min:0', 'max:9999'],
            'summary' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.unique' => 'Judul buku sudah digunakan.',
            'category.in' => 'Kategori yang dipilih tidak valid.',
            'published_year.max' => 'Tahun terbit tidak boleh lebih dari tahun depan.',
        ];
    }
}