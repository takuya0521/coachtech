<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginViewResponse;
use App\Http\Responses\LoginViewResponse as CustomLoginViewResponse;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Validation\ValidationException;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // ログインビューのレスポンス置き換え
        $this->app->singleton(LoginViewResponse::class, CustomLoginViewResponse::class);

        // ユーザー登録処理
        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::authenticateUsing(function ($request) {

            // 日本語バリデーション
            $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ], [
                'email.required' => 'メールアドレスを入力してください',
                'email.email'    => 'メールアドレスはメール形式で入力してください',
                'password.required' => 'パスワードを入力してください',
            ]);

            // 認証試行
            if (auth()->attempt($request->only('email', 'password'))) {
                return auth()->user();
            }

            // 認証失敗（COACHTECH 要件：固定文言）
            throw ValidationException::withMessages([
                'email' => 'ログイン情報が登録されていません',
            ]);
        });

        // ログイン試行のレート制限
        RateLimiter::for('login', function (Request $request) {
            $key = Str::lower($request->email) . '|' . $request->ip();
            return Limit::perMinute(5)->by($key);
        });

        // ログイン画面
        Fortify::loginView(function () {
            return view('auth.login');
        });

        // 登録画面
        Fortify::registerView(function () {
            return view('auth.register');
        });
    }
}
