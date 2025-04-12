<x-auth-layout>
    <x-slot name="title">Halaman Daftar</x-slot>

    <form method="POST" action="{{ route("register") }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label text-md-end">
                Nama Lengkap
            </label>

            <input id="name" type="text" class="form-control @error("name") is-invalid @enderror" name="name"
                value="{{ old("name") }}" required autocomplete="name" autofocus>

            @error("name")
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label text-md-end">
                Email
            </label>

            <input id="email" type="email" class="form-control @error("email") is-invalid @enderror"
                name="email" value="{{ old("email") }}" required autocomplete="email">

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
                name="password" required autocomplete="new-password">

            @error("password")
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password-confirm" class="form-label text-md-end">{{ __("Confirm Password") }}</label>

            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                autocomplete="new-password">
        </div>

        <div class="mb-0">
            <div class=" offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __("Register") }}
                </button>
            </div>
        </div>
    </form>
</x-auth-layout>
