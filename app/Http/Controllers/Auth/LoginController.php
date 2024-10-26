<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $user = User::updateOrCreate([
            'email' => $googleUser->getEmail(),
        ], [
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'image_url' => $googleUser->getAvatar(),
            // 必要に応じて他のフィールドを設定
            'password' => bcrypt(Str::random(16)), // ランダムなパスワードを生成（使用しないので任意でOK）
        ]);

        // ユーザーをログインさせる
        Auth::login($user, true);

        // ホームページへリダイレクト
        return redirect()->route('rooms.index');
    }
}
