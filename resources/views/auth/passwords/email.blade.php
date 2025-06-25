<x-auth-layout>
    <x-slot name="title">Halaman Reset Password</x-slot>
    <x-slot name="text">
        Masukkan alamat email Anda dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi.
    </x-slot>

    @if (session("status"))
        <div class="alert alert-primary" role="alert">
            {{ session("status") }}
        </div>
    @endif

    <form method="POST" action="{{ route("password.email") }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">{{ __("Email") }}</label>

            <input id="email" type="email" class="form-control @error("email") is-invalid @enderror" name="email"
                value="{{ old("email") }}" required autocomplete="email" autofocus>

            @error("email")
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>

        <div class="mb-0 d-grid">
            <button type="submit" class="btn btn-primary">
                {{ __("Kirim Link Reset Password") }}
            </button>

        </div>
    </form>
</x-auth-layout>
