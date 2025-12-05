@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-10">
    <div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-8">

        <h1 class="text-2xl font-bold text-gray-800 mb-6 border-l-4 border-blue-600 pl-3">
            お問い合わせフォーム
        </h1>

        <form action="{{ route('contact.confirm') }}" method="POST">
            @csrf

            {{-- 姓 --}}
            <div class="mb-4">
                <label class="block text-gray-700">姓 <span class="text-red-500">*</span></label>
                <input type="text" name="first_name"
                       value="{{ old('first_name') }}"
                       class="w-full border rounded-md p-2 mt-1 focus:outline-blue-500">
                @error('first_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 名 --}}
            <div class="mb-4">
                <label class="block text-gray-700">名 <span class="text-red-500">*</span></label>
                <input type="text" name="last_name"
                       value="{{ old('last_name') }}"
                       class="w-full border rounded-md p-2 mt-1 focus:outline-blue-500">
                @error('last_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 性別 --}}
            <div class="mb-4">
                <label class="block text-gray-700">性別 <span class="text-red-500">*</span></label>
                <div class="flex gap-4 mt-1">
                    <label><input type="radio" name="gender" value="1" {{ old('gender')=='1' ? 'checked' : '' }}> 男性</label>
                    <label><input type="radio" name="gender" value="2" {{ old('gender')=='2' ? 'checked' : '' }}> 女性</label>
                    <label><input type="radio" name="gender" value="3" {{ old('gender')=='3' ? 'checked' : '' }}> その他</label>
                </div>
                @error('gender')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- メールアドレス --}}
            <div class="mb-4">
                <label class="block text-gray-700">メールアドレス <span class="text-red-500">*</span></label>
                <input type="email" name="email"
                       value="{{ old('email') }}"
                       class="w-full border rounded-md p-2 mt-1 focus:outline-blue-500">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 電話番号（3分割） --}}
            <div class="mb-4">
                <label class="block text-gray-700">電話番号 <span class="text-red-500">*</span></label>
                <div class="flex items-center gap-2 mt-1">
                    <input type="text" name="tel1" value="{{ old('tel1') }}" class="w-20 border rounded-md p-2 focus:outline-blue-500">
                    <span>-</span>
                    <input type="text" name="tel2" value="{{ old('tel2') }}" class="w-20 border rounded-md p-2 focus:outline-blue-500">
                    <span>-</span>
                    <input type="text" name="tel3" value="{{ old('tel3') }}" class="w-20 border rounded-md p-2 focus:outline-blue-500">
                </div>

                @if ($errors->has('tel1') || $errors->has('tel2') || $errors->has('tel3'))
                    <p class="text-red-500 text-sm mt-1">
                        {{ $errors->first('tel1') ?? $errors->first('tel2') ?? $errors->first('tel3') }}
                    </p>
                @endif
            </div>

            {{-- 住所 --}}
            <div class="mb-4">
                <label class="block text-gray-700">住所 <span class="text-red-500">*</span></label>
                <input type="text" name="address"
                       value="{{ old('address') }}"
                       class="w-full border rounded-md p-2 mt-1 focus:outline-blue-500">
                @error('address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 建物名 --}}
            <div class="mb-4">
                <label class="block text-gray-700">建物名</label>
                <input type="text" name="building"
                       value="{{ old('building') }}"
                       class="w-full border rounded-md p-2 mt-1 focus:outline-blue-500">
            </div>

            {{-- お問い合わせの種類 --}}
            <div class="mb-4">
                <label class="block text-gray-700">お問い合わせの種類 <span class="text-red-500">*</span></label>
                <select name="category_id" class="w-full border rounded-md p-2 mt-1 focus:outline-blue-500">
                    <option value="">選択してください</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->content }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- お問い合わせ内容 --}}
            <div class="mb-6">
                <label class="block text-gray-700">お問い合わせ内容 <span class="text-red-500">*</span></label>
                <textarea name="detail" rows="5"
                          class="w-full border rounded-md p-2 mt-1 focus:outline-blue-500">{{ old('detail') }}</textarea>
                @error('detail')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 送信ボタン --}}
            <div class="text-center">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-md shadow">
                    確認画面へ
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
