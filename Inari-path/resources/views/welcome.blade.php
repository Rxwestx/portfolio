<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Top</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=M+PLUS+1p:wght@300;400;500&display=swap" rel="stylesheet">

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/css/custom.css', 'resources/js/app.js'])
    </head>

    <body class="m-plus-1p-regular antialiased bg-blade-pale text-gray-600">
        <main class="welcome-shell">
            <section class="welcome-hero">
                <div class="welcome-hero-copy">
                    <h1 class="welcome-title">Inari-Path</h1>
                {{-- ログイン・登録へのリンク --}}
                    <div class="mt-8 flex flex-col sm:flex-row items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a
                                href="{{ url('/dashboard') }}"
                                class="welcome-button welcome-button-primary"
                            >
                                記録一覧へ &gt;
                            </a>
                        @else
                            <a
                                href="{{ route('register') }}"
                                class="welcome-button welcome-button-primary"
                            >
                                今すぐ始める &gt;
                            </a>
                        @if (Route::has('register'))
                            <a
                                href="{{ route('login') }}"
                                class="welcome-button welcome-button-secondary"
                            >
                                Log in &gt;
                            </a>
                        @endif
                        @endauth
                    @endif
                    </div>
                </div>
                {{-- <div class="welcome-visual" aria-hidden="true">
                    <img
                        src="{{ asset('img/characters/rank_1.png') }}"
                        alt=""
                        class="welcome-character"
                    >
                </div> --}}
            </section>

            <section class="app-description welcome-content">
                {{-- アプリ説明 --}}
                <div class="welcome-panel welcome-panel-about">
                    <h2 class="welcome-section-title">
                        このアプリについて
                    </h2>
                    <p class="welcome-text leading-relaxed text-blade-dark whitespace-pre-line">
                    Inari-Pathは、習慣形成のためのモチベーション維持を目的とした学習ログ管理アプリです。
                    学習時間の積み重ねを妖狐の成長として可視化し、学びを楽しみながら継続できるように設計しました。
                    </p>
                </div>

                {{-- 使い方 --}}
                <div class="welcome-panel">
                    <h3 class="welcome-section-title">使い方</h3>
                    <p class="welcome-text leading-relaxed whitespace-pre-line">
                    1. 習慣を達成するための総時間を設定します（例: 読書100時間 / 勉強1000時間）。
                    2. 毎日の取り組み時間を記録して報告します。
                    3. 記録を重ねるほど、妖狐が力を取り戻し、姿が進化していきます。
                    （例: 目標設定を、”読書をする”目標時間を”100時間”に設定して1日1時間記録すると、約3か月で達成できます）
                    </p>
                </div>

                {{-- 世界観（補足） --}}
                <div class="welcome-panel welcome-panel-story">
                    <h3 class="welcome-section-title text-gray-500">Episode 0</h3>
                    <p class="welcome-text leading-relaxed text-gray-500 whitespace-pre-line">
                    あなたは、日々の忙しさに心をすり減らしていました。
                    ある日、ほんの少し現実から離れたくなり、神秘の森へと迷い込みます。
                    深い緑と木漏れ日に包まれた静かな場所で、傷ついた小さな妖狐が、ひとりうずくまっていました。
                    あなたはその妖狐にそっと手を差し伸べ、回復を見守る日々を始めます。
                    </p>
                </div>

            </section>
        </main>
    </body>
</html>
