<x-auth-layout>
    <x-slot name="title">Verifikasi Akun</x-slot>
    <x-slot name="text">
        Silakan verifikasi alamat email Anda untuk melanjutkan penggunaan aplikasi.
    </x-slot>

    @if (session("resent"))
        <div class="alert alert-primary" role="alert">
            {{ __("Link verifikasi baru telah dikirim ke alamat email Anda.") }}
        </div>
    @endif

    {{ __("Sebelum melanjutkan, silakan periksa email Anda untuk link verifikasi.") }}
    {{ __("Jika Anda tidak menerima email tersebut") }},
    <form class="d-inline" method="POST" action="{{ route("verification.resend") }}">
        @csrf
        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
            {{ __("klik di sini untuk meminta yang baru") }}
        </button>.
    </form>
</x-auth-layout>
