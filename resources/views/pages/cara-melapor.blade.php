@extends('layouts.app')

@section('content')
<section class="bg-slate-50 pt-20 pb-32 px-4 min-h-screen">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-16">
            <h1 class="text-4xl font-extrabold text-slate-900 mb-4">Cara Kerja <span class="text-sky-400">E-Lapor</span></h1>
            <p class="text-slate-500 max-w-xl mx-auto">Ikuti panduan sederhana berikut untuk mengirimkan pengaduan Anda dengan benar.</p>
        </div>

        <div class="space-y-12">
            <!-- Step 1 -->
            <div class="flex flex-col md:flex-row items-center gap-10 bg-white p-10 rounded-[2.5rem] card-shadow border border-slate-50">
                <div class="w-24 h-24 bg-sky-100 text-sky-500 rounded-full flex items-center justify-center text-4xl font-black shrink-0">1</div>
                <div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-3">Registrasi & Login</h3>
                    <p class="text-slate-500 leading-relaxed">Buat akun menggunakan email aktif Anda di halaman <a href="/register" class="text-sky-500 font-bold underline">Daftar</a>. Setelah memiliki akun, silakan masuk ke dashboard untuk memulai pelaporan.</p>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="flex flex-col md:flex-row items-center gap-10 bg-white p-10 rounded-[2.5rem] card-shadow border border-slate-50">
                <div class="w-24 h-24 bg-sky-100 text-sky-500 rounded-full flex items-center justify-center text-4xl font-black shrink-0">2</div>
                <div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-3">Isi Formulir Laporan</h3>
                    <p class="text-slate-500 leading-relaxed">Pilih kategori masalah (contoh: Sanitasi), masukkan judul pengaduan yang jelas, deskripsikan masalah secara mendetail, dan cantumkan alamat lokasi kejadian seakurat mungkin.</p>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="flex flex-col md:flex-row items-center gap-10 bg-white p-10 rounded-[2.5rem] card-shadow border border-slate-50">
                <div class="w-24 h-24 bg-sky-100 text-sky-500 rounded-full flex items-center justify-center text-4xl font-black shrink-0">3</div>
                <div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-3">Unggah Bukti Foto</h3>
                    <p class="text-slate-500 leading-relaxed">Lampirkan foto pendukung yang menunjukkan kondisi asli di lapangan. Foto yang jelas akan sangat membantu administrator dalam memverifikasi dan mempercepat tindak lanjut.</p>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="flex flex-col md:flex-row items-center gap-10 bg-white p-10 rounded-[2.5rem] card-shadow border border-slate-50">
                <div class="w-24 h-24 bg-sky-100 text-sky-500 rounded-full flex items-center justify-center text-4xl font-black shrink-0">4</div>
                <div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-3">Pantau Progres</h3>
                    <p class="text-slate-500 leading-relaxed">Setelah dikirim, Anda dapat melihat status laporan Anda di dashboard. Status akan berubah dari <span class="text-slate-500 font-bold">Menunggu</span> ke <span class="text-amber-500 font-bold">Diproses</span>, hingga <span class="text-green-500 font-bold">Selesai</span>.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection