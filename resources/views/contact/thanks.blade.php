@extends('layouts.app')

@section('content')
<div class="relative min-h-screen flex items-center justify-center bg-white">

    {{-- 薄い背景テキスト --}}
    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
        <span class="text-gray-100 text-9xl font-serif opacity-40 select-none">
            Thank you
        </span>
    </div>

    {{-- メインメッセージ --}}
    <div class="relative z-10 text-center">
        <p class="text-gray-700 text-lg mb-6">
            お問い合わせありがとうございました
        </p>

        <a href="{{ route('contact.index') }}"
           class="bg-gray-600 text-white px-8 py-2 rounded shadow hover:bg-gray-700">
            HOME
        </a>
    </div>

</div>
@endsection
