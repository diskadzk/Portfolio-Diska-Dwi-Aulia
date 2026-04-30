@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('content')
    <section class="mx-auto max-w-5xl rounded-3xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-200/60 sm:p-8">
        <div class="mb-6">
            <h2 class="mt-2 text-2xl font-bold text-slate-900">Tambah Buku Baru</h2>
            <p class="mt-2 text-sm leading-6 text-slate-600">Gunakan form ini untuk menambah data buku yang akan dipakai pada skenario pengujian.</p>
        </div>

        <form action="{{ route('books.store') }}" method="POST" class="space-y-6">
            @csrf
            @include('books._form', ['submitLabel' => 'Simpan Buku'])
        </form>
    </section>
@endsection