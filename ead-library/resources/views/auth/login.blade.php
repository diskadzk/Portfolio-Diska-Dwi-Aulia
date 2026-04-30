@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <section class="mx-auto max-w-lg rounded-3xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-200/60 sm:p-8">
        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-sky-600">Autentikasi</p>
        <h2 class="mt-2 text-2xl font-bold text-slate-900">Masuk ke Aplikasi</h2>
        <p class="mt-2 text-sm leading-6 text-slate-600">Gunakan akun terdaftar untuk mengakses modul buku.</p>

        @if ($errors->any())
            <div class="mt-6 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.store') }}" method="POST" class="mt-6 space-y-5">
            @csrf
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

            <label class="flex items-center gap-3 text-sm text-slate-600">
                <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-slate-300 bg-white text-sky-600 focus:ring-sky-300">
                Ingat saya
            </label>

            <button type="submit" class="btn-primary w-full">Login</button>
        </form>

        <p class="mt-6 text-sm text-slate-600">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold text-sky-700 hover:text-sky-800">Daftar di sini</a>
        </p>
    </section>
@endsection