@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <section class="mx-auto max-w-lg rounded-3xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-200/60 sm:p-8">
        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-sky-600">Autentikasi</p>
        <h2 class="mt-2 text-2xl font-bold text-slate-900">Buat Akun Baru</h2>
        <p class="mt-2 text-sm leading-6 text-slate-600">Registrasi digunakan untuk masuk ke modul CRUD buku.</p>

        <form action="{{ route('register.store') }}" method="POST" class="mt-6 space-y-5">
            @csrf

            <div>
                <label for="name" class="app-label">Nama</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" class="app-input">
                @error('name')<p class="app-error">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="email" class="app-label">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" class="app-input">
                @error('email')<p class="app-error">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="password" class="app-label">Password</label>
                <input id="password" name="password" type="password" class="app-input">
                @error('password')<p class="app-error">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="password_confirmation" class="app-label">Konfirmasi Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="app-input">
            </div>

            <button type="submit" class="btn-primary w-full">Register</button>
        </form>

        <p class="mt-6 text-sm text-slate-600">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-semibold text-sky-700 hover:text-sky-800">Login di sini</a>
        </p>
    </section>
@endsection