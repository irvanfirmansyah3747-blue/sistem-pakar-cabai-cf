@extends('layouts.app')

@section('title', 'Manajemen Akun Karyawan')

@section('content')
<div class="space-y-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-2 gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                <i data-lucide="users" class="w-6 h-6 text-emerald-600"></i>
                Manajemen Akun Karyawan Lapangan
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                Kelola hak akses dan akun staf persemaian Rumah Semai Helly Seedling.
            </p>
        </div>

        <div>
            <a href="{{ route('karyawan.create') }}" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20 transition flex items-center gap-1.5">
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                <span>Tambah Akun Karyawan</span>
            </a>
        </div>
    </div>

    <!-- Table of Karyawan -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                        <th class="py-3.5 px-4 w-12">No</th>
                        <th class="py-3.5 px-4">Nama Petugas</th>
                        <th class="py-3.5 px-4">Username</th>
                        <th class="py-3.5 px-4">Email Terdaftar</th>
                        <th class="py-3.5 px-4">Nomor HP / WhatsApp</th>
                        <th class="py-3.5 px-4 text-center">Diagnosa Dibuat</th>
                        <th class="py-3.5 px-4">Status Akun</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($karyawans as $idx => $k)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3 px-4 text-slate-400 font-mono">{{ $idx + 1 }}</td>
                            <td class="py-3 px-4 font-bold text-slate-900 flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xs">
                                    {{ substr($k->name, 0, 1) }}
                                </div>
                                <span>{{ $k->name }}</span>
                            </td>
                            <td class="py-3 px-4 font-mono text-slate-600">{{ $k->username ?? '-' }}</td>
                            <td class="py-3 px-4 text-slate-600">{{ $k->email }}</td>
                            <td class="py-3 px-4 text-slate-600">{{ $k->phone ?? '-' }}</td>
                            <td class="py-3 px-4 text-center font-bold text-emerald-700">{{ $k->diagnosas_count }} kasus</td>
                            <td class="py-3 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $k->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                    {{ $k->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('karyawan.edit', $k->id) }}" class="p-1.5 rounded-lg text-slate-500 hover:text-amber-600 hover:bg-amber-50" title="Edit Akun">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('karyawan.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Hapus akun karyawan ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50" title="Hapus">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-10 text-center text-slate-400">Belum ada akun karyawan terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

