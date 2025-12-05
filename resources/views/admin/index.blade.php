@extends('layouts.app')

@section('content')

<h2 class="text-center text-2xl font-serif text-gray-700 mb-10">Admin</h2>

{{-- 検索フォーム --}}
<form action="{{ route('admin.search') }}" method="GET" class="flex gap-3 mb-6">

    <input type="text" name="keyword"
        placeholder="名前やメールアドレスを入力してください"
        class="w-64 border px-3 py-2 rounded">

    <select name="gender" class="border px-3 py-2 rounded">
        <option value="">性別</option>
        <option value="1">男性</option>
        <option value="2">女性</option>
        <option value="3">その他</option>
    </select>

    <select name="category_id" class="border px-3 py-2 rounded">
        <option value="">お問い合わせの種類</option>
        @foreach ($categories as $cat)
            <option value="{{ $cat->id }}">{{ $cat->content }}</option>
        @endforeach
    </select>

    <input type="date" name="date" class="border px-3 py-2 rounded">

    <button class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800">
        検索
    </button>

    <a href="{{ route('admin.reset') }}"
        class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
        リセット
    </a>
</form>

{{-- エクスポート --}}
<a href="{{ route('admin.export') }}"
    class="inline-block mb-4 px-4 py-2 bg-gray-200 border rounded hover:bg-gray-300">
    エクスポート
</a>

{{-- 一覧テーブル --}}
<table class="w-full bg-white border rounded">
    <thead>
        <tr class="bg-[#a6907c] text-white text-left">
            <th class="p-3">お名前</th>
            <th class="p-3">性別</th>
            <th class="p-3">メールアドレス</th>
            <th class="p-3">お問い合わせの種類</th>
            <th class="p-3 w-24"></th>
        </tr>
    </thead>

   <tbody>
        @foreach ($contacts as $contact)
        <tr class="border-t hover:bg-gray-100 cursor-pointer">
            <td class="p-3">{{ $contact->last_name }}　{{ $contact->first_name }}</td>

            <td class="p-3">
                {{ ['1'=>'男性','2'=>'女性','3'=>'その他'][$contact->gender] }}
            </td>

            <td class="p-3">{{ $contact->email }}</td>

            <td class="p-3">{{ $contact->category->content }}</td>

            <td class="p-3 text-right flex gap-2">

    {{-- 詳細ボタン --}}
    <button
        onclick="openModal({{ $contact->id }})"
        class="border px-3 py-1 text-gray-600 rounded hover:bg-gray-200">
        詳細
    </button>

    {{-- 削除ボタン --}}
    <form action="{{ route('admin.delete') }}" method="POST"
          onsubmit="return confirm('本当に削除しますか？');">
        @csrf
        @method('DELETE')
        <input type="hidden" name="id" value="{{ $contact->id }}">
        <button class="border px-3 py-1 text-red-600 rounded hover:bg-red-100">
            削除
        </button>
    </form>

</td>

        </tr>
        @endforeach
    </tbody>

</table>

{{-- ページネーション --}}
<div class="mt-6 flex justify-center">
    {{ $contacts->links() }}
</div>

{{-- ▼ モーダル（詳細） ▼ --}}
<div id="detailModal"
     class="fixed inset-0 hidden justify-center items-center">



    <div class="bg-white w-96 p-6 rounded shadow-lg relative">

        {{-- 閉じるボタン --}}
        <button
            class="absolute top-2 right-2 text-gray-600 text-xl"
            onclick="closeModal()">
            ×
        </button>

        <h3 class="text-xl font-semibold mb-4">お問い合わせ詳細</h3>

        <div class="space-y-2">
            <p><strong>名前：</strong> <span id="m_name"></span></p>
            <p><strong>性別：</strong> <span id="m_gender"></span></p>
            <p><strong>メール：</strong> <span id="m_email"></span></p>
            <p><strong>電話番号：</strong> <span id="m_tel"></span></p>
            <p><strong>住所：</strong> <span id="m_address"></span></p>
            <p><strong>建物名：</strong> <span id="m_building"></span></p>
            <p><strong>種類：</strong> <span id="m_category"></span></p>
            <p><strong>内容：</strong> <span id="m_detail"></span></p>
        </div>
    </div>
</div>

{{-- ▼ JS（モーダル開閉とデータ表示） ▼ --}}
<script>
function openModal(id) {
    fetch(`/api/contact/${id}`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('m_name').textContent = data.last_name + ' ' + data.first_name;
            document.getElementById('m_gender').textContent = data.gender_text;
            document.getElementById('m_email').textContent = data.email;
            document.getElementById('m_tel').textContent = data.tel;
            document.getElementById('m_address').textContent = data.address;
            document.getElementById('m_building').textContent = data.building ?? '';
            document.getElementById('m_category').textContent = data.category;
            document.getElementById('m_detail').textContent = data.detail;

            document.getElementById('detailModal').classList.remove('hidden');
            document.getElementById('detailModal').classList.add('flex');
        });
}

function closeModal() {
    const modal = document.getElementById('detailModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>


@endsection
