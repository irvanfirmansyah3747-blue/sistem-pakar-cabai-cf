@extends('layouts.app')

@section('title', 'Tambah Akun Karyawan')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('karyawan.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-emerald-700 transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Data Karyawan</span>
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm">
        <h1 class="text-xl font-bold text-slate-900 mb-1">Tambah Akun Karyawan Lapangan Baru</h1>
        <p class="text-xs text-slate-500 mb-6">Buat akun untuk staf atau teknisi pembibitan di Rumah Semai Helly Seedling.</p>

        <form action="{{ route('karyawan.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap Karyawan</label>
                <input type="text" name="name" required placeholder="Budi Pratama" value="{{ old('name') }}"
                       class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Username Login</label>
                    <input type="text" name="username" required placeholder="budi" value="{{ old('username') }}"
                           class="w-full text-xs p-2.5 rounded-xl border border-slate-200 font-mono focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Email Aktif</label>
                    <input type="email" name="email" required placeholder="budi@hellyseedling.com" value="{{ old('email') }}"
                           class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor WhatsApp / HP</label>
                    <input type="text" name="phone" placeholder="0821-xxxx-xxxx" value="{{ old('phone') }}"
                           class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kata Sandi Awal</label>
                    <input type="password" name="password" required placeholder="Minimal 6 karakter"
                           class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end gap-2">
                <a href="{{ route('karyawan.index') }}" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20">
                    Buat Akun Karyawan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

