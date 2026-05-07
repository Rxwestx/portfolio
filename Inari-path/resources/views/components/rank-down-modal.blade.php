@props(['oldRankName', 'newRankName', 'daysSinceLastLog'])

{{-- 背景オーバーレイ（画面全体を覆う半透明の背景） --}}
<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" id="rank-down-modal"
    x-data="{ show: true }" x-show="show" x-cloak>

    {{-- モーダルボックス本体 --}}
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">

        {{-- コンテンツエリア --}}
        <div class="mt-3 text-center">

            {{-- 警告アイコン（赤い三角マーク） --}}
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>

            {{-- タイトル --}}
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">
                ランクダウンしました
            </h3>

            {{-- メッセージ本文 --}}
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    {{ $daysSinceLastLog }}日間、学習記録がありませんでした。
                </p>
                <p class="text-lg font-bold text-red-600 mt-2">
                    ランク名: {{ $oldRankName }} → ランク名: {{ $newRankName }}
                </p>
                <p class="text-xs text-gray-400 mt-2">
                    継続して学習を記録しましょう！
                </p>
            </div>

            {{-- OKボタン --}}
            <div class="items-center px-4 py-3">
                <button @click="show = false"
                    class="px-4 py-2 bg-blade-dark text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blade-pale hover:text-blade-dark focus:outline-none focus:ring-2 focus:ring-blade-dark">
                    分かりました
                </button>
            </div>
        </div>
    </div>
</div>
