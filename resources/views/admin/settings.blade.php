@extends('layouts.admin')

@section('content')
<div class="mb-12">
    <h2 class="text-3xl font-black text-slate-800 tracking-tight">Setelan Sistem</h2>
    <p class="text-slate-400 text-sm mt-1">Konfigurasi parameter operasional aplikasi E-LAPOR.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
    <!-- General Settings -->
    <div class="glass-card p-10 rounded-[3rem] shadow-xl border border-slate-200/50">
        <h3 class="font-black text-slate-800 text-xl mb-8 flex items-center gap-4">
            <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center border border-indigo-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                </svg>
            </div>
            Identitas Aplikasi
        </h3>

        <div class="space-y-6">
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nama Platform</label>
                <input type="text" value="E-LAPOR PRO" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition outline-none text-slate-700 font-bold">
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Slogan Instansi</label>
                <input type="text" value="Layanan Pengaduan Masyarakat Modern" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition outline-none text-slate-700 font-bold">
            </div>
            <button class="w-full bg-indigo-600 text-white py-4 rounded-2xl font-black text-sm hover:bg-indigo-700 transition shadow-lg shadow-indigo-600/20">
                Simpan Konfigurasi
            </button>
        </div>
    </div>

    <!-- Security Settings -->
    <div class="glass-card p-10 rounded-[3rem] shadow-xl border border-slate-200/50">
        <h3 class="font-black text-slate-800 text-xl mb-8 flex items-center gap-4">
            <div class="w-10 h-10 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center border border-red-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            Keamanan & Akses
        </h3>

        <div class="space-y-6">
            <div class="flex items-center justify-between p-6 bg-slate-50 rounded-[2rem] border border-slate-100">
                <div>
                    <h4 class="font-bold text-slate-800 text-sm">Registrasi Terbuka</h4>
                    <p class="text-slate-400 text-[10px]">Izinkan masyarakat baru untuk mendaftar.</p>
                </div>
                <div class="w-12 h-6 bg-emerald-500 rounded-full relative cursor-pointer shadow-inner">
                    <div class="absolute right-1 top-1 w-4 h-4 bg-white rounded-full transition"></div>
                </div>
            </div>
            <div class="flex items-center justify-between p-6 bg-slate-50 rounded-[2rem] border border-slate-100">
                <div>
                    <h4 class="font-bold text-slate-800 text-sm">Unggah Foto Bukti</h4>
                    <p class="text-slate-400 text-[10px]">Wajibkan unggahan foto saat membuat laporan.</p>
                </div>
                <div class="w-12 h-6 bg-emerald-500 rounded-full relative cursor-pointer shadow-inner">
                    <div class="absolute right-1 top-1 w-4 h-4 bg-white rounded-full transition"></div>
                </div>
            </div>
            <p class="text-[10px] text-slate-400 italic text-center">* Fitur sistem sedang dalam pengembangan lebih lanjut.</p>
        </div>
    </div>
</div>

<script>
    document.getElementById('pageTitle').innerText = 'Setelan Sistem';
</script>
@endsection