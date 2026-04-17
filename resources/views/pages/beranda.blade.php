@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="hero-gradient pt-16 pb-24 px-4 relative overflow-hidden">
    <!-- Decorative background circles -->
    <div class="absolute top-20 left-20 w-72 h-72 bg-elapor-200/30 rounded-full blur-3xl -z-10"></div>
    <div class="absolute bottom-10 right-10 w-96 h-96 bg-elapor-100/20 rounded-full blur-3xl -z-10"></div>

    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-8">
        <div class="flex-1 text-center md:text-left">
            <div class="inline-flex items-center gap-2 bg-white/70 backdrop-blur-sm text-elapor-600 px-4 py-2 rounded-full text-xs font-bold mb-6 border border-elapor-200 uppercase tracking-widest shadow-sm">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-elapor-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-elapor-500"></span>
                </span>
                Platform Laporan Digital Terpercaya
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-900 leading-tight mb-6">
                Wujudkan Kota yang <span class="text-elapor-400">Lebih Baik</span> Melalui Suara Anda.
            </h1>
            <p class="text-base md:text-lg text-slate-600 mb-8 leading-relaxed max-w-xl">
                E-Lapor hadir sebagai jembatan masa kini antara aspirasi warga dan aksi nyata pemerintah. Laporkan berbagai isu lingkungan secara transparan, aman, dan cepat.
            </p>
            <div class="flex flex-col sm:flex-row items-center gap-4 justify-center md:justify-start">
                <a href="/login" class="bg-gradient-to-r from-elapor-500 to-elapor-400 text-white px-8 py-4 rounded-2xl font-bold hover:from-elapor-600 hover:to-elapor-500 transition shadow-lg shadow-elapor-200 w-full sm:w-auto text-center flex items-center justify-center gap-2">
                    Buat Pengaduan <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
                <a href="/daftar-pengaduan" class="border-2 border-slate-200 bg-white text-slate-600 px-8 py-4 rounded-2xl font-bold hover:bg-slate-50 hover:border-slate-300 transition w-full sm:w-auto text-center">
                    Lihat Pengaduan
                </a>
            </div>
        </div>
        <div class="flex-1 relative flex justify-center">
            <img src="{{ asset('images/hero-city.png') }}" alt="Smart City Illustration" class="w-full max-w-lg h-auto rounded-3xl float-animation">
        </div>
    </div>
</section>

<!-- Fitur Utama -->
<section id="tentang" class="py-24 bg-white px-4">
    <div class="max-w-7xl mx-auto text-center mb-16">
        <h2 class="text-3xl font-extrabold mb-4 text-gray-900">Fitur Utama Sistem</h2>
        <p class="text-gray-500">Kami memberikan kenyamanan dan keamanan dalam setiap laporan Anda.</p>
    </div>
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="p-8 bg-slate-50/80 rounded-2xl border border-slate-100 hover:border-elapor-300 hover:shadow-lg transition-all duration-300 group">
            <div class="w-14 h-14 bg-elapor-50 text-elapor-500 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-elapor-100 transition">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold mb-3 text-gray-900">Kemudahan Melapor</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Laporkan masalah cukup menggunakan ponsel Anda, lampirkan foto dan lokasi secara real-time.</p>
        </div>
        <div class="p-8 bg-slate-50/80 rounded-2xl border border-slate-100 hover:border-elapor-300 hover:shadow-lg transition-all duration-300 group">
            <div class="w-14 h-14 bg-elapor-50 text-elapor-500 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-elapor-100 transition">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold mb-3 text-gray-900">Transparansi Proses</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Pantau setiap tahapan tindak lanjut laporan Anda secara transparan hingga status selesai.</p>
        </div>
        <div class="p-8 bg-slate-50/80 rounded-2xl border border-slate-100 hover:border-elapor-300 hover:shadow-lg transition-all duration-300 group">
            <div class="w-14 h-14 bg-elapor-50 text-elapor-500 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-elapor-100 transition">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold mb-3 text-gray-900">Akses Online 24 Jam</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Kami mendengarkan kapan saja. Layanan digital kami siap menerima aduan Anda 24/7 tanpa antre.</p>
        </div>
    </div>
</section>

<!-- Cara Melapor Section - Light background matching screenshot -->
<section id="cara-melapor" class="py-24 bg-gradient-to-b from-slate-50 to-white px-4 overflow-hidden relative">
    <div class="max-w-7xl mx-auto text-center mb-16 relative z-10">
        <h2 class="text-3xl font-extrabold mb-4 text-gray-900">4 Langkah Mudah Melapor</h2>
        <p class="text-gray-500">Alur pengaduan yang ringkas dan efektif bagi seluruh warga.</p>
    </div>
    <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8 relative z-10">
        <!-- Step 1 -->
        <div class="text-center group">
            <div class="relative mx-auto mb-6">
                <div class="w-20 h-20 bg-elapor-50 rounded-2xl flex items-center justify-center mx-auto border border-elapor-100 group-hover:border-elapor-300 group-hover:shadow-lg transition-all duration-300">
                    <div class="w-12 h-12 step-icon rounded-full flex items-center justify-center text-xl font-extrabold text-white shadow-md">1</div>
                </div>
            </div>
            <h4 class="font-bold mb-2 text-gray-900">Daftar Akun</h4>
            <p class="text-xs text-gray-500 leading-relaxed px-2">Buat akun untuk melacak dan mengelola laporan Anda secara personal.</p>
        </div>
        <!-- Step 2 -->
        <div class="text-center group">
            <div class="relative mx-auto mb-6">
                <div class="w-20 h-20 bg-elapor-50 rounded-2xl flex items-center justify-center mx-auto border border-elapor-100 group-hover:border-elapor-300 group-hover:shadow-lg transition-all duration-300">
                    <div class="w-12 h-12 step-icon rounded-full flex items-center justify-center text-xl font-extrabold text-white shadow-md">2</div>
                </div>
            </div>
            <h4 class="font-bold mb-2 text-gray-900">Isi Formulir</h4>
            <p class="text-xs text-gray-500 leading-relaxed px-2">Jelaskan detail masalah, unggah foto, dan tentukan lokasi.</p>
        </div>
        <!-- Step 3 -->
        <div class="text-center group">
            <div class="relative mx-auto mb-6">
                <div class="w-20 h-20 bg-elapor-50 rounded-2xl flex items-center justify-center mx-auto border border-elapor-100 group-hover:border-elapor-300 group-hover:shadow-lg transition-all duration-300">
                    <div class="w-12 h-12 step-icon rounded-full flex items-center justify-center text-xl font-extrabold text-white shadow-md">3</div>
                </div>
            </div>
            <h4 class="font-bold mb-2 text-gray-900">Kirim Laporan</h4>
            <p class="text-xs text-gray-500 leading-relaxed px-2">Laporan Anda akan diverifikasi oleh sistem dan administrator.</p>
        </div>
        <!-- Step 4 -->
        <div class="text-center group">
            <div class="relative mx-auto mb-6">
                <div class="w-20 h-20 bg-elapor-50 rounded-2xl flex items-center justify-center mx-auto border border-elapor-100 group-hover:border-elapor-300 group-hover:shadow-lg transition-all duration-300">
                    <div class="w-12 h-12 step-icon rounded-full flex items-center justify-center text-xl font-extrabold text-white shadow-md">4</div>
                </div>
            </div>
            <h4 class="font-bold mb-2 text-gray-900">Pantau Status</h4>
            <p class="text-xs text-gray-500 leading-relaxed px-2">Dapatkan notifikasi perubahan status hingga masalah teratasi.</p>
        </div>
    </div>
</section>

<!-- Statistik -->
<section class="py-16 bg-white px-4">
    <div class="max-w-5xl mx-auto grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="stat-card text-center py-8 px-6 rounded-2xl hover:shadow-lg transition-all duration-300">
            <div class="text-4xl font-extrabold text-elapor-500 mb-2">1,240+</div>
            <div class="text-sm font-semibold text-elapor-400 uppercase tracking-wider">Total Laporan</div>
        </div>
        <div class="stat-card text-center py-8 px-6 rounded-2xl hover:shadow-lg transition-all duration-300">
            <div class="text-4xl font-extrabold text-elapor-500 mb-2">85</div>
            <div class="text-sm font-semibold text-elapor-400 uppercase tracking-wider">Sedang Diproses</div>
        </div>
        <div class="stat-card text-center py-8 px-6 rounded-2xl hover:shadow-lg transition-all duration-300">
            <div class="text-4xl font-extrabold text-elapor-500 mb-2">1,155+</div>
            <div class="text-sm font-semibold text-elapor-400 uppercase tracking-wider">Laporan Selesai</div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-20 px-4">
    <div class="max-w-4xl mx-auto cta-gradient rounded-3xl p-12 md:p-16 text-center text-white relative overflow-hidden shadow-xl shadow-elapor-200/50">
        <div class="relative z-10">
            <h2 class="text-3xl md:text-4xl font-extrabold mb-6 leading-tight">Mari bangun kota yang lebih baik bersama-sama.</h2>
            <p class="mb-10 text-white/90 max-w-lg mx-auto leading-relaxed">Kontribusi kecil Anda dengan melapor dapat mencegah dampak besar bagi masyarakat sekitar.</p>
            <a href="/register" class="bg-white text-elapor-500 px-10 py-4 rounded-2xl font-bold hover:bg-slate-50 transition inline-block shadow-lg hover:shadow-xl">Mulai Lapor Sekarang</a>
        </div>
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-60 h-60 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-60 h-60 bg-elapor-700/20 rounded-full blur-3xl"></div>
    </div>
</section>
@endsection