<?php

namespace App\Http\Requests;

use App\Models\Book;
use Illuminate\Validation\Rule;

class UpdateBookRequest extends StoreBookRequest
{
	public function rules(): array
	{
		return [
			'title' => ['required', 'string', 'max:150', Rule::unique('books', 'title')->ignore($this->route('book'))],
			'author' => ['required', 'string', 'max:120', 'regex:/^[^\d]+$/'],
			'category' => ['required', 'string', Rule::in(Book::categories())],
			'published_year' => ['required', 'integer', 'min:1900', 'max:' . now()->addYear()->year],
			'stock' => ['required', 'integer', 'min:0', 'max:9999'],
			'summary' => ['nullable', 'string', 'max:500'],
		];
	}

	public function messages(): array
	{
		return array_merge(parent::messages(), [
			'author.regex' => 'Penulis tidak boleh mengandung angka.',
		]);
	}
}
