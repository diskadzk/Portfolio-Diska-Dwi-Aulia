@extends('layouts.app')

@section('title', $book->title)

@section('content')
    <section class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-200/60 sm:p-8">
            <h2 class="mt-2 text-3xl font-bold text-slate-900">{{ $book->title }}</h2>
            <p class="mt-3 text-sm text-slate-600">{{ $book->summary ?: 'Tidak ada ringkasan untuk buku ini.' }}</p>

            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                <div class="min-w-0 rounded-2xl border border-slate-200 bg-white p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Penulis</p>
                    <p class="mt-2 wrap-break-word text-base font-semibold text-slate-900">{{ $book->author }}</p>
                </div>
                <div class="min-w-0 rounded-2xl border border-slate-200 bg-white p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Kategori</p>
                    <p class="mt-2 wrap-break-word text-base font-semibold text-slate-900">{{ $book->category }}</p>
                </div>
                <div class="min-w-0 rounded-2xl border border-slate-200 bg-white p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Tahun Terbit</p>
                    <p class="mt-2 wrap-break-word text-base font-semibold text-slate-900">{{ $book->published_year }}</p>
                </div>
                <div class="min-w-0 rounded-2xl border border-slate-200 bg-white p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Stok</p>
                    <p class="mt-2 wrap-break-word text-base font-semibold text-slate-900">{{ $book->stock }}</p>
                </div>
            </div>

            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('books.edit', $book) }}" class="btn-primary">Edit Buku</a>
                <a href="{{ route('books.index') }}" class="btn-secondary">Kembali</a>
            </div>
        </div>

        <aside class="rounded-3xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-200/60 sm:p-8">
            <dl class="mt-5 space-y-4 text-sm text-slate-600">
                <div class="flex items-start justify-between gap-4 border-b border-slate-200 pb-3">
                    <dt class="shrink-0">ID Buku</dt>
                    <dd class="min-w-0 wrap-break-word text-right font-semibold text-slate-900">{{ $book->id }}</dd>
                </div>
                <div class="flex items-start justify-between gap-4 border-b border-slate-200 pb-3">
                    <dt class="shrink-0">Dibuat</dt>
                    <dd class="min-w-0 wrap-break-word text-right font-semibold text-slate-900">{{ $book->created_at?->format('d M Y H:i') }}</dd>
                </div>
                <div class="flex items-start justify-between gap-4 border-b border-slate-200 pb-3">
                    <dt class="shrink-0">Diubah</dt>
                    <dd class="min-w-0 wrap-break-word text-right font-semibold text-slate-900">{{ $book->updated_at?->format('d M Y H:i') }}</dd>
                </div>
            </dl>

            <form action="{{ route('books.destroy', $book) }}" method="POST" class="mt-6" onsubmit="return confirm('Hapus buku ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger w-full justify-center">Hapus Buku</button>
            </form>
        </aside>
    </section>
@endsection