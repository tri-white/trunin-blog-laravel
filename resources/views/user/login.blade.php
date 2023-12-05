@extends('shared/layout')

@section('content')
<main>
    <div class="profile-form container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <h1 class="mb-4 text-center">Авторизація</h1>

                <form method="post" action="{{ route('login') }}" autocomplete="off">
                    @csrf
                    <div class="mb-3">
                        <label for="emailInput" class="form-label">Емейл</label>
                        <input value="{{ old('email') }}" name="email" type="email" class="form-control" id="emailInput" required>
                    </div>
                    <div class="mb-3">
                        <label for="passwordInput" class="form-label">Пароль</label>
                        <input value="{{ old('password') }}" name="password" type="password" class="form-control" id="passwordInput" required>
                    </div>
                    <div class="text-center mt-5">
                        <button type="submit" class="fs-4 px-4 btn btn-dark">Увійти</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
