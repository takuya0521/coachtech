@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">ユーザー登録</h1>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label>お名前</label>
            <input type="text" name="name" class="w-full border p-2">
            @error('name')
                <p class="text-red-500 text-sm">{{ $message }}</p> 
            @enderror
        </div>

        <div class="mb-3">
            <label>メールアドレス</label>
            <input type="email" name="email" class="w-full border p-2">
            @error('email')
                <p class="text-red-500 text-sm">{{ $message }}</p> 
            @enderror
        </div>

        <div class="mb-3">
            <label>パスワード</label>
            <input type="password" name="password" class="w-full border p-2">
            @error('password')
                <p class="text-red-500 text-sm">{{ $message }}</p> 
            @enderror
        </div>

        {{-- ★ ボタン中央寄せ ★ --}}
        <div class="text-center mt-4">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                登録
            </button>
        </div>

    </form>
</div>
@endsection
