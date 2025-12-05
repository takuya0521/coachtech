<?php

use Illuminate\Support\Facades\Route;
use App\Models\Contact;

Route::get('/contact/{id}', function ($id) {
    $c = Contact::with('category')->findOrFail($id);

    return [
        'first_name' => $c->first_name,
        'last_name' => $c->last_name,
        'gender_text' => ['1'=>'男性','2'=>'女性','3'=>'その他'][$c->gender],
        'email'      => $c->email,
        'tel'        => $c->tel,
        'address'    => $c->address,
        'building'   => $c->building,
        'category'   => $c->category->content,
        'detail'     => $c->detail,
    ];
});
