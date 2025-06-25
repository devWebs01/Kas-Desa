<x-auth-layout>
    <x-slot name="title">Konfirmasi Kata Sandi</x-slot>
    <x-slot name="text"> Silakan konfirmasi kata sandi Anda sebelum melanjutkan.
    </x-slot>

    <form method="POST" action="{{ route("password.confirm") }}">
        @csrf

        <div class="row mb-3">
            <label for="password" class="col-md-4 col-form-label text-md-end">Kata Sandi</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control @error("password") is-invalid @enderror"
                    name="password" required autocomplete="current-password">

                @error("password")
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    Konfirmasi Kata Sandi
                </button>

                @if (Route::has("password.request"))
                    <a class="btn btn-link" href="{{ route("password.request") }}">
                        Lupa Kata Sandi?
                    </a>
                @endif
            </div>
        </div>
    </form>
</x-auth-layout>
