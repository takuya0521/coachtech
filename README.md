README
アプリケーション名

お問い合わせ管理アプリ（COACHTECH 課題）

環境構築

重要：本リポジトリは Laravel Sail を使用しています。
clone 直後は vendor/ が存在しないため、先に composer install が必要です。

前提

Docker Desktop（起動していること）

（Windows の場合）WSL2 推奨

まずはコピペで一発（推奨）

<リポジトリ URL> だけ自分のものに置き換えてください

80 番ポートが埋まっている場合は「80 番ポートが使用中の場合」のコマンドを使ってください

実行コマンド（通常）：
git clone <リポジトリ URL> contact-app
cd contact-app
composer install
cp .env.example .env
./vendor/bin/sail up -d
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed

80 番ポートが使用中の場合：
APP_PORT=8080 ./vendor/bin/sail up -d

手順を分けて実行する場合

1. リポジトリを取得

git clone <リポジトリ URL> contact-app
cd contact-app

2. PHP 依存関係をインストール（vendor を作成）

composer install

3. .env を作成・設定

cp .env.example .env

.env の DB 設定を以下にしてください：
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password

4. コンテナ起動（Sail）

./vendor/bin/sail up -d

80 番ポートが使用中の場合：
APP_PORT=8080 ./vendor/bin/sail up -d

5. アプリ初期化（キー生成・マイグレーション）

./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed

6. コンテナに入る（任意）

./vendor/bin/sail bash

開発環境 URL

お問い合わせフォーム： http://localhost/

APP_PORT=8080 で起動した場合： http://localhost:8080/

ログインページ： /login

会員登録ページ： /register

管理画面（ログイン後）： /admin

使用技術（実行環境）

Laravel（12.x）

Laravel Sail（Docker）

MySQL（Sail）

nginx（Sail）

ER 図
<img width="909" height="739" alt="image" src="https://github.com/user-attachments/assets/76b0aaa7-3c48-4b9b-8660-9d63420c3685" />
使用方法

会員登録ページで管理者アカウントを作成

ログインして管理画面へアクセス

ユーザーは / からお問い合わせを送信

管理画面で検索・詳細表示・削除・エクスポートが可能

機能一覧

お問い合わせ送信（確認画面あり）

バリデーション（要件準拠、エラー文日本語対応）

管理画面で一覧表示（ページネーション 7 件）

詳細モーダル表示

検索（名前 / メール / 性別 / 種類 / 日付）

リセット機能

CSV エクスポート

管理者ログイン / 登録 / ログアウト

URL（まとめ）

/

/login

/register

/admin
