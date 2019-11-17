@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <h1 class="mb-3 text-center">
                Hiita
                <small class="text-muted">弓道の練習記録サービス</small>
            </h1>
            <p class="text-center">
                手書きでの記録や的中率の計算から解放されます！<br>
                アドバイスなどメモも一緒に記録できます！<br>
                PC/スマホ/タブレット　対応しています！<br>
            </p>
            <p class="text-center">
                ぜひ一度、お試しください！
            </p>
            <div class="text-center">
                <a class="btn btn-outline-primary" href="{{ route('register') }}">{{ __('Register') }}</a>
            </div>
            <div class="text-center mt-4">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <input type="hidden" name="email" value="test@test.co.jp">
                <input type="hidden" name="password" value="testtest">

                <p>テストユーザーはこちら</p>
                <button type="submit" class="btn btn-primary">
                    テストログイン
                </button>

            </form>
            </div>
        </div>
    </div>
@endsection