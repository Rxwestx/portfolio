<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Top</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=M+PLUS+1:wght@300;400;500&family=Montserrat:wght@500;600&display=swap" rel="stylesheet">

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/css/custom.css', 'resources/js/app.js'])
    </head>

    <body class="m-plus-1p-regular antialiased bg-[#f3f7f9] text-slate-700">
        <main class="min-h-screen w-full bg-[linear-gradient(180deg,rgba(158,205,165,0.28)_0%,rgba(221,239,227,0.55)_42%,rgba(243,247,249,0)_72%)]">
            <section class="mx-auto grid w-full max-w-[1040px] place-items-center px-4 pb-8 pt-16 text-center sm:pb-12 sm:pt-20" aria-labelledby="welcome-title">
                <div class="relative z-10 mx-auto w-full max-w-3xl text-center">
                    <h1 id="welcome-title" class="font-['Montserrat'] text-[48px] font-semibold leading-none text-[#24382d] sm:text-[72px]">Inari-Path</h1>
                {{-- ログイン・登録へのリンク --}}
                    <div class="mt-8 flex flex-col items-center gap-3 sm:flex-row sm:justify-center">
                    @if (Route::has('login'))
                        @auth
                            <a
                                href="{{ url('/dashboard') }}"
                                class="inline-flex min-h-12 min-w-44 items-center justify-center rounded-[5px] border border-[#41956a] bg-[#41956a] px-6 py-3 text-base font-medium leading-none text-white shadow-[0_8px_18px_rgba(65,149,106,0.18)] transition hover:-translate-y-0.5 hover:bg-[#367c58] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#9ecda5]"
                            >
                                記録一覧へ &gt;
                            </a>
                        @else
                            <a
                                href="{{ route('register') }}"
                                class="inline-flex min-h-12 min-w-44 items-center justify-center rounded-[5px] border border-[#41956a] bg-[#41956a] px-6 py-3 text-base font-medium leading-none text-white shadow-[0_8px_18px_rgba(65,149,106,0.18)] transition hover:-translate-y-0.5 hover:bg-[#367c58] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#9ecda5]"
                            >
                                今すぐ始める &gt;
                            </a>
                        @if (Route::has('register'))
                            <a
                                href="{{ route('login') }}"
                                class="inline-flex min-h-12 min-w-44 items-center justify-center rounded-[5px] border border-[#9ecda5] bg-white px-6 py-3 text-base font-medium leading-none text-[#41956a] shadow-[0_8px_18px_rgba(65,149,106,0.1)] transition hover:-translate-y-0.5 hover:bg-[#ddefe3] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#9ecda5]"
                            >
                                Log in &gt;
                            </a>
                        @endif
                        @endauth
                    @endif
                    </div>
                </div>
            </section>

            <section class="mx-auto grid w-full max-w-[960px] gap-4 px-4 pb-16 sm:pb-20">
                {{-- アプリ説明 --}}
                <div class="grid border-l-[6px] border-l-[#9ecda5] bg-white/90 p-6 shadow-[0_16px_40px_rgba(65,149,106,0.08)] sm:grid-cols-[minmax(12rem,0.34fr)_minmax(0,1fr)] sm:gap-x-10 sm:p-8">
                    <h2 class="mb-4 font-['Montserrat'] text-[24px] font-semibold leading-8 text-[#24382d] sm:mb-0">
                        このアプリについて
                    </h2>
                    <p class="m-0 whitespace-pre-line text-left text-base leading-8 text-[#526057]">
                    Inari-Pathは、習慣形成のためのモチベーション維持を目的とした学習ログ管理アプリです。
                    学習時間の積み重ねを妖狐の成長として可視化し、学びを楽しみながら継続できるように設計しました。
                    </p>
                </div>

                {{-- 使い方 --}}
                <div class="grid border-l-[6px] border-l-[#41956a] bg-white/90 p-6 shadow-[0_16px_40px_rgba(65,149,106,0.08)] sm:grid-cols-[minmax(12rem,0.34fr)_minmax(0,1fr)] sm:gap-x-10 sm:p-8">
                    <h3 class="mb-4 font-['Montserrat'] text-[24px] font-semibold leading-8 text-[#24382d] sm:mb-0">使い方</h3>
                    <p class="m-0 whitespace-pre-line text-left text-base leading-8 text-[#526057]">
                    1. 習慣を達成するための総時間を設定します（例: 読書100時間 / 勉強1000時間）。
                    2. 毎日の取り組み時間を記録して報告します。
                    3. 記録を重ねるほど、妖狐が力を取り戻し、姿が進化していきます。
                    （例: 目標設定を、”読書をする”目標時間を”100時間”に設定して1日1時間記録すると、約3か月で達成できます）
                    </p>
                </div>

                {{-- 世界観（補足） --}}
                <div class="grid border-l-[6px] border-l-[#ddefe3] bg-white/90 p-6 shadow-[0_16px_40px_rgba(65,149,106,0.08)] sm:grid-cols-[minmax(12rem,0.34fr)_minmax(0,1fr)] sm:gap-x-10 sm:p-8">
                    <h3 class="mb-4 font-['Montserrat'] text-[24px] font-semibold leading-8 text-slate-500 sm:mb-0">Episode 0</h3>
                    <p class="m-0 whitespace-pre-line text-left text-base leading-8 text-slate-500">
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
