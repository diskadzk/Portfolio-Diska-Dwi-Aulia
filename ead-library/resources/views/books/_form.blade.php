@php
    $categories = \App\Models\Book::categories();
@endphp

<div class="grid gap-5 lg:grid-cols-2">
    <div>
        <label for="title" class="app-label">Judul Buku</label>
        <input id="title" name="title" type="text" value="{{ old('title', $book->title) }}" class="app-input" placeholder="Judul Buku">
        @error('title')<p class="app-error">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="author" class="app-label">Penulis</label>
        <input id="author" name="author" type="text" value="{{ old('author', $book->author) }}" class="app-input" placeholder="Penulis">
        @error('author')<p class="app-error">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="category" class="app-label">Kategori</label>
        <select id="category" name="category" class="app-select">
            <option value="">Pilih kategori</option>
            @foreach ($categories as $category)
                <option value="{{ $category }}" @selected(old('category', $book->category) === $category)>{{ $category }}</option>
            @endforeach
        </select>
        @error('category')<p class="app-error">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="published_year" class="app-label">Tahun Terbit</label>
        <input id="published_year" name="published_year" type="number" min="1900" max="{{ now()->addYear()->year }}" value="{{ old('published_year', $book->published_year) }}" class="app-input" placeholder="2024">
        @error('published_year')<p class="app-error">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="stock" class="app-label">Stok</label>
        <input id="stock" name="stock" type="number" min="0" value="{{ old('stock', $book->stock) }}" class="app-input" placeholder="10">
        @error('stock')<p class="app-error">{{ $message }}</p>@enderror
    </div>

    <div class="lg:col-span-2">
        <label for="summary" class="app-label">Ringkasan</label>
        <textarea id="summary" name="summary" rows="5" class="app-textarea" placeholder="Ringkasan singkat buku...">{{ old('summary', $book->summary) }}</textarea>
        @error('summary')<p class="app-error">{{ $message }}</p>@enderror
    </div>
</div>

<div class="mt-8 flex flex-wrap gap-3">
    <button type="submit" class="btn-primary">{{ $submitLabel }}</button>
    <a href="{{ route('books.index') }}" class="btn-secondary">Batal</a>
</div>