@extends('layouts.app')

@section('content')
<section class="gradient-bg pt-20 pb-32 px-4 min-h-screen">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-[3rem] p-12 card-shadow border border-slate-50">
            <h1 class="text-4xl font-extrabold text-slate-900 mb-8 text-center uppercase tracking-tighter">Tentang <span class="text-sky-400">E-Lapor</span></h1>

            <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed space-y-6">
                <p class="text-lg">
                    <strong>E-Lapor</strong> adalah inisiatif teknologi sipil yang dirancang untuk menjembatani aspirasi masyarakat dengan transparansi tata kelola pemerintahan. Kami percaya bahwa setiap masalah lingkungan—mulai dari infrastruktur yang rusak hingga sanitasi yang buruk—adalah prioritas yang layak mendapatkan perhatian cepat.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 my-12">
                    <div class="p-8 bg-sky-50 rounded-3xl">
                        <h3 class="text-xl font-bold text-sky-600 mb-2">Visi Kami</h3>
                        <p class="text-sm">Mewujudkan lingkungan masyarakat yang teratur, bersih, dan aman melalui partisipasi aktif warga berbasis digital.</p>
                    </div>
                    <div class="p-8 bg-slate-50 rounded-3xl">
                        <h3 class="text-xl font-bold text-slate-800 mb-2">Misi Kami</h3>
                        <p class="text-sm">Menyediakan platform pelaporan yang mudah digunakan, transparan, dan dapat dipertanggungjawabkan secara real-time.</p>
                    </div>
                </div>

                <p>
                    Sistem ini terintegrasi langsung dengan panel administrator yang memverifikasi setiap laporan. Dengan teknologi enkripsi dan validasi data, kami memastikan identitas pelapor terlindungi sementara suara mereka tetap terdengar nyaring di pusat kendali layanan publik.
                </p>

                <div class="bg-primary-blue p-8 rounded-3xl text-white text-center mt-12">
                    <h3 class="text-2xl font-bold mb-2">Mulai Langkah Anda</h3>
                    <p class="opacity-90 mb-6">Jadilah bagian dari solusi untuk kota kita.</p>
                    <a href="/register" class="bg-white text-sky-400 px-8 py-3 rounded-xl font-bold hover:bg-slate-50 transition inline-block">Daftar Sekarang</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection