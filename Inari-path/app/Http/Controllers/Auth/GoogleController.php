<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }
    public function callback()
    // 以下、既存のコード...
    {
        // 環境差で state エラーが出る場合があるので、まずは stateless で確実に動かす
        $googleUser = Socialite::driver('google')->stateless()->user(); // :contentReference[oaicite:2]{index=2}

        // 最小ルール：メールが同じなら同一ユーザー
        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name' => $googleUser->getName() ?? 'Google User',
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'password' => bcrypt(Str::random(32)), // password NOT NULL対策（Breeze等）
            ]);
        } elseif (!$user->google_id) {
            $user->update(['google_id' => $googleUser->getId()]);
        }

        Auth::login($user, true);

        // 初回判定：Goalがまだ無いなら goals/create へ
        if ($user->goals()->doesntExist()) {
            return redirect()->route('goals.create'); // ルート名がある場合
            // ルート名が無いなら: return redirect('/goals/create');
        }

        // 2回目以降は dashboard
        return redirect()->intended('/dashboard');
    }
}
