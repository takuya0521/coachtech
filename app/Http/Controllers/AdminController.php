<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * PG04 管理画面：a一覧表示
     */
    public function index(Request $request)
    {
        $categories = Category::all();

        $query = Contact::with('category');

        // 名前検索（姓・名・両方・フルネーム対応）
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('first_name', 'LIKE', "%$keyword%")
                ->orWhere('last_name', 'LIKE', "%$keyword%")
                ->orWhereRaw("CONCAT(last_name, first_name) LIKE ?", ["%$keyword%"]);
            });
        }

        // 性別（1,2,3）
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        // カテゴリー
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // 日付検索（created_at の年月日一致）
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // データ取得（7件/ページ → FN021 指定）
        $contacts = $query->orderBy('created_at', 'desc')->paginate(7);

        return view('admin.index', compact('contacts', 'categories'));
    }

    public function delete(Request $request)
    {
        $contact = Contact::find($request->id);

        if ($contact) {
            $contact->delete();
        }

        return redirect()->route('admin.index')
                        ->with('success', '削除しました');
    }

    public function search(Request $request)
    {
        $query = Contact::with('category');

        // キーワード（名前 or メールアドレス）
        if (!empty($request->keyword)) {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('first_name', 'like', "%{$keyword}%")
                ->orWhere('last_name', 'like', "%{$keyword}%")
                ->orWhereRaw("CONCAT(last_name, first_name) LIKE ?", ["%{$keyword}%"])
                ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        // 性別
        if (!empty($request->gender)) {
            $query->where('gender', $request->gender);
        }

        // カテゴリー
        if (!empty($request->category_id)) {
            $query->where('category_id', $request->category_id);
        }

        // 日付（created_at）
        if (!empty($request->date)) {
            $query->whereDate('created_at', $request->date);
        }

        // 15件でページネーション
        $contacts = $query->orderBy('created_at', 'desc')->paginate(15);

        // 検索結果でもカテゴリー一覧は必要
        $categories = Category::all();

        return view('admin.index', compact('contacts', 'categories'))
            ->with('search', true);
    }

    public function reset()
    {
        return redirect()->route('admin.index');
    }

    public function export(Request $request)
    {
        // 検索条件（search と同じロジック）
        $query = Contact::with('category');

        if (!empty($request->keyword)) {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('first_name', 'like', "%{$keyword}%")
                    ->orWhere('last_name', 'like', "%{$keyword}%")
                    ->orWhereRaw("CONCAT(last_name, first_name) LIKE ?", ["%{$keyword}%"])
                    ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        if (!empty($request->gender)) {
            $query->where('gender', $request->gender);
        }

        if (!empty($request->category_id)) {
            $query->where('category_id', $request->category_id);
        }

        if (!empty($request->date)) {
            $query->whereDate('created_at', $request->date);
        }

        $contacts = $query->orderBy('created_at', 'desc')->get();

        // CSV データ作成
        $csvHeader = [
            'お名前',
            '性別',
            'メールアドレス',
            '電話番号',
            '住所',
            '建物名',
            'お問い合わせの種類',
            'お問い合わせ内容',
        ];

        $csvData = $contacts->map(function ($c) {
            return [
                $c->last_name . ' ' . $c->first_name,
                ['1' => '男性', '2' => '女性', '3' => 'その他'][$c->gender],
                $c->email,
                $c->tel,
                $c->address,
                $c->building,
                $c->category->content,
                $c->detail,
            ];
        });

        // ファイル名
        $fileName = 'contacts_' . date('Ymd_His') . '.csv';

        // CSV をストリームで返す
        $callback = function () use ($csvHeader, $csvData) {
            $file = fopen('php://output', 'w');

            // BOM（Excelでも文字化けしないように）
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, $csvHeader);

            foreach ($csvData as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->streamDownload($callback, $fileName, [
            "Content-Type" => "text/csv",
        ]);
    }

}
