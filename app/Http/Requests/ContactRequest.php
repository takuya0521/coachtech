<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // お名前
            'first_name' => 'required|string|max:8',
            'last_name'  => 'required|string|max:8',

            // 性別
            'gender'     => 'required|in:1,2,3',

            // メールアドレス
            'email'      => 'required|email',

            // 電話番号（3 分割）
            'tel1' => ['required', 'regex:/^[0-9]{1,5}$/'],
            'tel2' => ['required', 'regex:/^[0-9]{1,5}$/'],
            'tel3' => ['required', 'regex:/^[0-9]{1,5}$/'],

            // 住所
            'address'    => 'required|string',

            // 建物名（任意）
            'building'   => 'nullable|string',

            // お問い合わせの種類
            'category_id' => 'required|exists:categories,id',

            // お問い合わせ内容
            'detail'     => 'required|string|max:120',
        ];
    }

    public function messages(): array
    {
        return [
            // お名前
            'first_name.required' => '姓を入力してください',
            'last_name.required'  => '名を入力してください',

            // 性別
            'gender.required'     => '性別を選択してください',

            // メール
            'email.required'      => 'メールアドレスを入力してください',
            'email.email'         => 'メールアドレスはメール形式で入力してください',

            // 電話番号
            'tel1.required'       => '電話番号を入力してください',
            'tel2.required'       => '電話番号を入力してください',
            'tel3.required'       => '電話番号を入力してください',

            'tel1.regex'          => '電話番号は 半角英数字で入力してください',
            'tel2.regex'          => '電話番号は 半角英数字で入力してください',
            'tel3.regex'          => '電話番号は 半角英数字で入力してください',

            'tel1.digits_between' => '電話番号は 5桁まで数字で入力してください',
            'tel2.digits_between' => '電話番号は 5桁まで数字で入力してください',
            'tel3.digits_between' => '電話番号は 5桁まで数字で入力してください',

            // 住所
            'address.required'    => '住所を入力してください',

            // お問い合わせの種類
            'category_id.required' => 'お問い合わせの種類を選択してください',

            // お問い合わせ内容
            'detail.required'     => 'お問い合わせ内容を入力してください',
            'detail.max'          => 'お問い合わせ内容は120文字以内で入力してください',
        ];
    }
}
