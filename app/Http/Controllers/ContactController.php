<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Category;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * PG01 入力ページ
     */
    public function index()
    {
        $categories = Category::all();
        return view('contact.index', compact('categories'));
    }

    /**
     * PG02 確認ページ
     */
    public function confirm(ContactRequest $request)
    {
        // 電話番号を結合
        $tel = $request->tel1 . $request->tel2 . $request->tel3;

        // 入力内容を配列にまとめる
        $input = $request->all();
        $input['tel'] = $tel;

        // 性別文字列変換
        $genderText = [
            1 => '男性',
            2 => '女性',
            3 => 'その他'
        ];
        $input['gender_text'] = $genderText[$input['gender']];

        // セッションに保存（送信処理用）
        $request->session()->put('contact_input', $input);

        // カテゴリー名取得
        $category = Category::find($input['category_id']);
        $input['category_name'] = $category->content;

        return view('contact.confirm', ['contact' => $input]);
    }

    /**
     * PG03 送信 → DB 保存 → thanks
     */
    public function send(Request $request)
    {
        // セッションから取り出し
        $input = $request->session()->get('contact_input');

        if (!$input) {
            return redirect()->route('contact.index');
        }

        // DB保存（必要な項目だけ保存）
        Contact::create([
            'first_name'  => $input['first_name'],
            'last_name'   => $input['last_name'],
            'gender'      => $input['gender'],
            'email'       => $input['email'],
            'tel'         => $input['tel'],
            'address'     => $input['address'],
            'building'    => $input['building'] ?? null,
            'category_id' => $input['category_id'],
            'detail'      => $input['detail'],
        ]);

        // セッション削除
        $request->session()->forget('contact_input');

        return view('contact.thanks');
    }
}
