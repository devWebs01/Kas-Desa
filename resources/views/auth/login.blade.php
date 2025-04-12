<x-auth-layout>
    <x-slot name="title">Halaman Masuk</x-slot>
    <form method="POST" action="{{ route("login") }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label text-md-end">
                Email
            </label>

            <input id="email" type="email" class="form-control @error("email") is-invalid @enderror" name="email"
                value="{{ old("email") }}" required autocomplete="email" autofocus>

            @error("email")
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>

        <div class="mb-3">
            <label for="password" class="form-label text-md-end">
                Kata Sandi
            </label>

            <input id="password" type="password" class="form-control @error("password") is-invalid @enderror"
                name="password" required autocomplete="current-password">

            @error("password")
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>

        <div class="mb-3">
            <div class="d-flex justify-content-between mx-1">
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                        {{ old("remember") ? "checked" : "" }}>

                    <label class="form-check-label" for="remember">
                        Ingat Saya
                    </label>
                </div>

                @if (Route::has("password.request"))
                    <div class="text-end">
                        <a class="btn btn-link" href="{{ route("password.request") }}">
                            Lupa Kata Sandi?
                        </a>
                    </div>
                @endif
            </div>

        </div>

        <div class="mb-0 d-grid">
            <button type="submit" class="btn btn-primary">
                Masuk
            </button>
        </div>
    </form>
</x-auth-layout>
