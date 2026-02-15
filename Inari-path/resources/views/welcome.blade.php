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
                {{-- 画像 --}}
                <div class="m-16 flex justify-center">
                    <img src="{{ asset('img/characters/rank_0.png') }}" alt="Fox Image" class="w-128 h-128 object-cover rounded-lg shadow-lg">
                </div>
                {{-- タイトル --}}
                <h1 class="m-4 text-2xl text-gray-900 text-center">
                    アプリ説明
                </h1>
                    {{-- 説明文 --}}
                    <p class="leading-relaxed text-gray-600 text-center whitespace-pre-line">
                        あなたは、日々の忙しさに疲れ、少しだけ現実から離れたくなっていた。
                        そんなある日、ふと迷い込んだ神秘の森。
                        深い緑のなか、柔らかな光が差し込む場所で一匹の小さな狐が怪我をして倒れていた。
                        あなたはその狐を助け、看病することにした。
                    </p>
                    <p class="text-xl leading-relaxed  text-blade-dark text-center whitespace-pre-line">
                        このアプリは、習慣化達成×育成アプリです。
                    </p>
                    <p class="m-1 leading-relaxed text-gray-600 text-center whitespace-pre-line">
                        まず、習慣を達成するための総時間(例:100時間読書/1000時間勉強など)をセットしましょう。
                        時間を記録して報告すると、徐々に妖狐は力を取り戻していきます。
                        妖狐は成長とともに、さまざまな姿に進化していきますが、
                        記録入力をサボり過ぎると、退化してしまいますので、ご注意を!!
                        （ランクは、下がりますが猶予あります）
                    </p>
                <div class="my-10 text-xl text-center flex flex-col items-center gap-4 ">
                @if (Route::has('login'))
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="rounded-md px-3 py-2 text-gray-900 ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            記録一覧へ &gt;
                        </a>
                        @else
                        <a
                            href="{{ route('login') }}"
                            class="rounded-md px-3 py-2 text-gray-900 ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Log in &gt;
                        </a>
                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="rounded-md px-3 py-2 text-gray-900 ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                            今すぐ始める &gt;
                            </a>
                        @endif
                    @endauth
                @endif
                </div>
            </section>
        </main>
    </body>
</html>
