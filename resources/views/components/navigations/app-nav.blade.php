<?php

use App\Models\Setting;
use function Livewire\Volt\{state};

state([
    "setting" => fn() => Setting::first() ?? "",
]);
?>

@volt
    <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <div class="app-brand demo">
            <a href="{{ route("home") }}" class="app-brand-link">
                <span class="demo menu-text fw-bolder">{{ $setting->name }}</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
        </div>

        <div class="menu-inner-shadow"></div>

        <ul class="menu-inner py-1">

            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Dashboard</span>
            </li>

            <li class="menu-item">
                <a class="menu-link {{ Route::is("home") ? "active" : "" }}" href="{{ route("home") }}">
                    <i class='menu-icon tf-icons bx bx-home-smile'></i>
                    <div>Beranda</div>
                </a>
            </li>

            @if (Auth()->User()->role === "ADMIN")
                <li class="menu-item ">
                    <a class="menu-link {{ Route::is(["users/*", "users"]) ? "active" : "" }}"
                        href="{{ route("users.index") }}">
                        <i class='menu-icon tf-icons bx bxs-user'></i>
                        <div>Akun Pengguna</div>
                    </a>
                </li>

                <li class="menu-item">
                    <a class="menu-link {{ Route::is(["settings/*", "settings"]) ? "active" : "" }}"
                        href="{{ route("settings.show") }}">
                        <i class='menu-icon tf-icons bx bxs-cog'></i>
                        <div>Pengaturan</div>
                    </a>
                </li>
            @endif

            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Transaksi</span>
            </li>

            <li class="menu-item">
                <a class="menu-link {{ Route::is(["recipients.index", "recipients.index/*"]) ? "active" : "" }}"
                    href="{{ route("recipients.index") }}">
                    <i class='menu-icon tf-icons bx bxs-user-rectangle'></i>
                    <div>Data Penerima</div>
                </a>
            </li>

            <li class="menu-item">
                <a class="menu-link {{ Route::is(["transactions.index", "transactions/*"]) ? "active" : "" }}"
                    href="{{ route("transactions.index") }}">
                    <i class='menu-icon tf-icons bx bx-money'></i>
                    <div>Transaksi</div>
                </a>
            </li>

            <li class="menu-item">
                <a class="menu-link {{ Route::is(["reports.transaction"]) ? "active" : "" }}"
                    href="{{ route("reports.transaction") }}">
                    <i class='menu-icon tf-icons bx bx-file'></i>
                    <div>Laporan Transaksi</div>
                </a>
            </li>

        </ul>
    </aside>
@endvolt
