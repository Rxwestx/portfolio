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
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="m-plus-1p-regular antialiased bg-blade-pale">
        <main class="w-full mx-auto px-4 sm:px-6 lg:px-8">
            <section class="app-description">
                <h1 class="m-16 text-3xl text-gray-600 text-center">Inari-Path</h1>
                {{-- ログイン・登録へのリンク --}}
                <div class="my-10 text-xl text-center flex flex-col sm:flex-row items-center justify-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a
                                href="{{ url('/dashboard') }}"
                                class="inline-flex items-center justify-center rounded-full px-5 py-2.5 text-sm font-semibold text-gray-600 bg-blade-dark shadow-sm transition hover:-translate-y-0.5 hover:bg-blade-main focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2"
                            >
                                記録一覧へ &gt;
                            </a>
                        @else
                            <a
                                href="{{ route('register') }}"
                                class="inline-flex items-center justify-center rounded-full px-5 py-2.5 text-sm font-semibold text-gray-600 bg-amber-400 shadow-sm transition hover:-translate-y-0.5 hover:bg-amber-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-400 focus-visible:ring-offset-2"
                            >
                                今すぐ始める &gt;
                            </a>
                        @if (Route::has('register'))
                            <a
                                href="{{ route('login') }}"
                                class="inline-flex items-center justify-center rounded-full px-5 py-2.5 text-sm font-semibold text-gray-600 bg-blade-main shadow-sm transition hover:-translate-y-0.5 hover:bg-blade-dark focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blade-main focus-visible:ring-offset-2"
                            >
                                Log in &gt;
                            </a>
                        @endif
                        @endauth
                    @endif
                </div>
                {{-- アプリ説明 --}}
                <h2 class="m-4 text-lg text-gray-600 text-center">
                    このアプリについて
                </h2>                {{-- アプリ説明 --}}
                <p class="leading-relaxed text-blade-dark text-center whitespace-pre-line">
                    Inari-Pathは、習慣形成のためのモチベーション維持を目的とした学習ログ管理アプリです。
                    学習時間の積み重ねを妖狐の成長として可視化し、学びを楽しみながら継続できるように設計しました。
                </p>

                {{-- 使い方 --}}
                <h3 class="mt-8 text-lg text-gray-600 text-center">使い方</h3>
                <p class="m-1 leading-relaxed text-gray-600 text-center whitespace-pre-line">
                    1. 習慣を達成するための総時間を設定します（例: 読書100時間 / 勉強1000時間）。
                    2. 毎日の取り組み時間を記録して報告します。
                    3. 記録を重ねるほど、妖狐が力を取り戻し、姿が進化していきます。
                    （例: 目標設定を、”読書をする”目標時間を”100時間”に設定して1日1時間記録すると、約3か月で達成できます）
                </p>

                {{-- 世界観（補足） --}}
                <h3 class="mt-8 text-gray-500 text-center">Episode 0</h3>
                <p class="leading-relaxed text-gray-500 text-center whitespace-pre-line">
                    あなたは、日々の忙しさに心をすり減らしていました。
                    ある日、ほんの少し現実から離れたくなり、神秘の森へと迷い込みます。
                    深い緑と木漏れ日に包まれた静かな場所で、傷ついた小さな妖狐が、ひとりうずくまっていました。
                    あなたはその妖狐にそっと手を差し伸べ、回復を見守る日々を始めます。
                </p>

            </section>
        </main>
    </body>
</html>
