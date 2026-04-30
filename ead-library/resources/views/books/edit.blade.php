@extends('layouts.app')

@section('title', 'Ubah Buku')

@section('content')
    <section class="mx-auto max-w-5xl rounded-3xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-200/60 sm:p-8">
        <div class="mb-6">
            <h2 class="mt-2 text-2xl font-bold text-slate-900">Ubah Data Buku</h2>
            <p class="mt-2 text-sm leading-6 text-slate-600">Perbarui data buku ini untuk menguji alur update pada aplikasi CRUD.</p>
        </div>

        <form action="{{ route('books.update', $book) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            @include('books._form', ['submitLabel' => 'Perbarui Buku'])
        </form>
    </section>
@endsection