@extends('shared/layout')

@section('content')
<main>
    <div class="profile-form container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <h1 class="mb-4 text-center">Реєстрація</h1>

                @if(session('existing-user'))
                    <div class="alert alert-danger">{{ session('existing-user') }}</div>
                @endif

                <form method="post" action="{{ route('registration') }}" autocomplete="off">
                    @csrf
                    <div class="mb-3">
                        <label for="emailInput" class="form-label">Емейл</label>
                        <input value="{{ old('email') }}" name="email" type="email" class="form-control" id="emailInput"
                               required>
                    </div>
                    <div class="mb-3">
                        <label for="passwordInput" class="form-label">Пароль</label>
                        <input value="{{ old('password') }}" name="password" type="password" class="form-control"
                               id="passwordInput" required>
                    </div>
                    <div class="mb-3">
                        <label for="passwordRepeatInput" class="form-label">Повторіть пароль</label>
                        <input value="{{ old('password2') }}" name="password2" type="password" class="form-control"
                               id="passwordRepeatInput" required>
                    </div>
                    <div class="text-center mt-5">
                        <input type="submit" class="fs-4 px-4 btn btn-dark" value="Зареєструватися">
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
