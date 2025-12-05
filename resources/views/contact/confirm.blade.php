@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-10">
    <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-10">

        <h1 class="text-2xl font-bold text-center text-gray-700 mb-8">
            Confirm
        </h1>

        <table class="w-full border-collapse mb-10">
            <tbody>

                <tr class="border-t">
                    <th class="bg-gray-200 w-1/3 text-left p-3 font-medium">お名前</th>
                    <td class="p-3">
                        {{ $contact['first_name'] }}　{{ $contact['last_name'] }}
                    </td>
                </tr>

                <tr class="border-t">
                    <th class="bg-gray-200 p-3 text-left font-medium">性別</th>
                    <td class="p-3">
                        {{ ['1' => '男性', '2' => '女性', '3' => 'その他'][$contact['gender']] }}
                    </td>
                </tr>

                <tr class="border-t">
                    <th class="bg-gray-200 p-3 text-left font-medium">メールアドレス</th>
                    <td class="p-3">{{ $contact['email'] }}</td>
                </tr>

                <tr class="border-t">
                    <th class="bg-gray-200 p-3 text-left font-medium">電話番号</th>
                    <td class="p-3">{{ $contact['tel'] }}</td>
                </tr>

                <tr class="border-t">
                    <th class="bg-gray-200 p-3 text-left font-medium">住所</th>
                    <td class="p-3">{{ $contact['address'] }}</td>
                </tr>

                <tr class="border-t">
                    <th class="bg-gray-200 p-3 text-left font-medium">建物名</th>
                    <td class="p-3">{{ $contact['building'] }}</td>
                </tr>

                <tr class="border-t">
                    <th class="bg-gray-200 p-3 text-left font-medium">お問い合わせの種類</th>
                    <td class="p-3">{{ $contact['category_name'] }}</td>
                </tr>

                <tr class="border-t border-b">
                    <th class="bg-gray-200 p-3 text-left font-medium">お問い合わせ内容</th>
                    <td class="p-3 whitespace-pre-line">
                        {{ $contact['detail'] }}
                    </td>
                </tr>

            </tbody>
        </table>

        {{-- ボタン：送信・修正 --}}
        <form action="{{ route('contact.send') }}" method="POST" class="text-center mb-4">
            @csrf
            @foreach ($contact as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach

            <button type="submit"
                class="bg-gray-700 text-white px-10 py-2 rounded-md shadow hover:bg-gray-800">
                送信
            </button>
        </form>

        <div class="text-center">
            <button onclick="history.back()"
                class="border border-gray-500 px-10 py-2 rounded-md text-gray-700 hover:bg-gray-100">
                修正
            </button>
        </div>

    </div>
</div>
@endsection
