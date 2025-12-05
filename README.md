# README

## アプリケーション名

お問い合わせ管理アプリ（COACHTECH 課題）

---

## 環境構築

### Docker ビルド

-   git clone <リポジトリ URL>
-   cd contact-app
-   docker-compose up -d --build

### Laravel 環境構築

-   ./vendor/bin/sail bash
-   composer install
-   cp .env.example .env
-   以下の内容に `.env` を修正

DB_CONNECTION=mysql  
DB_HOST=mysql  
DB_PORT=3306  
DB_DATABASE=laravel  
DB_USERNAME=sail  
DB_PASSWORD=password

-   php artisan key:generate
-   php artisan migrate --seed

---

## 開発環境 URL

-   お問い合わせフォーム  
    http://localhost/

-   ログインページ  
    http://localhost/login

-   会員登録ページ  
    http://localhost/register

-   管理画面（ログイン後）  
    http://localhost/admin

---

## 使用技術（実行環境）

-   PHP 8.5
-   Laravel 12.x
-   Laravel Sail（Docker）
-   MySQL 8.4
-   nginx（Sail）

---

## ER 図

（ER 図画像をここに貼ってください）

---

## 使用方法

1. 会員登録ページで管理者アカウントを作成
2. ログインして管理画面へアクセス
3. ユーザーは / からお問い合わせを送信
4. 管理画面で検索・詳細表示・削除・エクスポートが可能

---

## 機能一覧

-   お問い合わせ送信（確認画面あり）
-   バリデーション（要件準拠、エラー文日本語対応）
-   管理画面で一覧表示（ページネーション 7 件）
-   詳細モーダル表示
-   検索（名前 / メール / 性別 / 種類 / 日付）
-   リセット機能
-   CSV エクスポート
-   管理者ログイン / 登録 / ログアウト

---

## URL（まとめ）

-   http://localhost/
-   http://localhost/login
-   http://localhost/register
-   http://localhost/admin

---
