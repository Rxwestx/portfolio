# Inari-path

本アプリは、学習の目標設定・学習記録・達成率の可視化を一つにまとめた、学習ログ管理用のポートフォリオです。
学習時間の積み重ねを狐のキャラクターの成長として可視化し、学びを楽しみながら継続できるようにしました。

## URL
  https://inari-path-12345.fly.dev

## 想定ユーザー / 解決する課題

- 想定ユーザー: 学習習慣を継続したい初学者・社会人学習者
- 課題:
  - 学習の継続が難しい
  - 進捗が見えずモチベーションが下がる
- 解決:
  - 学習時間の記録と可視化
  - 達成率表示とキャラクター成長演出で継続を支援

## 機能要件

- ユーザー登録 / ログイン
- ゲストログイン
- Googleソーシャルログイン
- パスワードリセット
- 学習・作業時間の記録
- 目標設定（内容・期間・総目標時間）
- 達成率の自動計算
- キャラクターの成長・ランク管理
- ダッシュボード表示
  - キャラクター情報
  - 達成状況
  - 累計時間
  - 週別学習時間グラフ
  - 直近の記録一覧
- 学習記録の一覧・編集・削除

## 使用技術

- HTML / CSS / JavaScript
- Blade
- Tailwind CSS
- Alpine.js
- Chart.js
- Vite（ビルドツール）
- PHP
- Laravel
- PostgreSQL
- Laravel Sail（Docker）

## 非機能要件

- モバイルファースト設計（スマートフォン最優先）
- タブレット / PC は最低限のレスポンシブ対応
- 学習ログを快適に操作できるパフォーマンスを重視
- セキュリティ
  - Laravel標準のセッション認証
  - CSRF / XSS 対策

## 仕様書

### プロトタイプ
<img width="1180" height="1019" alt="Wirefreme2" src="https://github.com/user-attachments/assets/c5c11936-bc8f-4bf5-bb35-13c787d005d5" />
<img width="1239" height="205" alt="Character_rank" src="https://github.com/user-attachments/assets/c4dceaae-2731-4a20-9403-baefeb4b8cc0" />

## ER図
 <img width="958" height="934" alt="Inari-path_ER" src="https://github.com/user-attachments/assets/2e0d5443-3df2-4a0b-acf0-5ff2392fa5a2" />
