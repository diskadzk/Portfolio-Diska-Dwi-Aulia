@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
    <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-lg shadow-slate-200/60 sm:p-6">
        <div>
            <h2 class="text-xl font-semibold text-slate-900">Daftar Buku</h2>
            <p class="mt-1 text-sm text-slate-600">
                Data buku yang sudah ditambahkan ke sistem.
            </p>
        </div>

        <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-left">
                    <thead class="bg-slate-50 text-xs uppercase tracking-[0.24em] text-slate-500">
                        <tr>
                            <th class="px-5 py-4">Judul</th>
                            <th class="px-5 py-4">Penulis</th>
                            <th class="px-5 py-4">Kategori</th>
                            <th class="px-5 py-4">Tahun</th>
                            <th class="px-5 py-4">Stok</th>
                            <th class="px-5 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse ($books as $book)
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-4">
                                    <div class="font-semibold text-slate-900">{{ $book->title }}</div>
                                    <div class="mt-1 max-w-md text-sm text-slate-500">{{ \Illuminate\Support\Str::limit($book->summary ?? 'Tidak ada ringkasan.', 90) }}</div>
                                </td>
                                <td class="px-5 py-4 text-slate-700">{{ $book->author }}</td>
                                <td class="px-5 py-4 text-slate-700">{{ $book->category }}</td>
                                <td class="px-5 py-4 text-slate-700">{{ $book->published_year }}</td>
                                <td class="px-5 py-4 text-slate-700">{{ $book->stock }}</td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-2 whitespace-nowrap">
                                        <a href="{{ route('books.show', $book) }}" class="btn-mini">Detail</a>
                                        <a href="{{ route('books.edit', $book) }}" class="btn-mini">Edit</a>
                                        <form method="POST" action="{{ route('books.destroy', $book) }}" onsubmit="return confirm('Hapus buku ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-mini btn-danger" aria-label="Hapus buku" title="Hapus buku">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="14" height="14" fill="currentColor" aria-hidden="true">
                                                    <path d="M9 3a1 1 0 0 0-1 1v1H5a1 1 0 1 0 0 2h.22l.77 11.06A2 2 0 0 0 7.98 20h8.04a2 2 0 0 0 1.99-1.94L18.78 7H19a1 1 0 1 0 0-2h-3V4a1 1 0 0 0-1-1H9Zm1 2V5h4V5h-4Zm-1.78 3h1.56l.23 9H8.85l-.63-9Zm5.77 0h1.56l-.63 9h-1.16l.23-9Z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-12 text-center text-slate-500">
                                    Tidak ada data buku untuk ditampilkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <p class="text-sm text-slate-600">
                Menampilkan {{ $books->firstItem() ?? 0 }} - {{ $books->lastItem() ?? 0 }} dari {{ $books->total() }} data.
            </p>
            <div class="pagination-wrap">
                {{ $books->links() }}
            </div>
        </div>
    </section>
@endsection