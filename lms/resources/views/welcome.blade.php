<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Top</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans antialiased bg-green-100">
        <main>
            {{-- 画像 --}}
            <div class="mt-24 flex justify-center">
                <img src="{{ asset('img/characters/rank_0.png') }}" alt="Fox Image" class="w-128 h-128 object-cover border-4 border-blue-400">
            </div>
            {{-- タイトル --}}
            <h2 class="m-16 text-2xl font-black text-center">
                アプリ説明
            </h2>
            {{-- 説明文 --}}
            <p class="text-xl leading-relaxed text-center whitespace-pre-line">
                あなたは、日々の忙しさに疲れ、少しだけ現実から離れたくなっていた。</br>
                そんなある日、ふと迷い込んだ神秘の森。</br>
                深い緑の中、柔らかな光が差し込む場所で、一匹の小さな狐が怪我をして倒れていた。</br>
                このアプリは、目標達成×育成アプリです。</br>
                毎日、あなたの目標時間（例：30分読書、1時間勉強など）をセットしよう。<br>
                目標を達成して報告すると、妖狐は少しずつ力を取り戻します。<br>
                妖狐は成長とともに、さまざまな姿に進化していきますが、</br>
                サボり過ぎると、退化してしまうので、ご注意を!!<br>
                （ランクは、下がりますが猶予あります）
            </p>
            <div class="my-10 text-xl text-center flex flex-col items-center gap-4 ">
            @if (Route::has('login'))
                @auth
                    <a
                        href="{{ url('/dashboard') }}"
                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                    >
                        Dashboard
                    </a>
                    @else
                    <a
                        href="{{ route('login') }}"
                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                    >
                        Log in
                    </a>
                    @if (Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                        今すぐ始める &gt;
                        </a>
                    @endif
                @endauth
            @endif
        </main>
    </body>
</html>
