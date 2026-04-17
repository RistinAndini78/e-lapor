@extends('layouts.app')

@section('content')
<section class="bg-slate-50 pt-20 pb-32 px-4 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h1 class="text-4xl font-extrabold text-slate-900 mb-4">Daftar Pengaduan <span class="text-sky-400">Terbaru</span></h1>
            <p class="text-slate-500 max-w-xl mx-auto">Transparansi laporan masyarakat untuk pemantauan bersama.</p>
        </div>

        <div id="publicLaporanList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Dynamic content -->
            <div class="col-span-full py-20 text-center text-slate-400">Memuat pengaduan masyarakat...</div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const list = document.getElementById('publicLaporanList');
        try {
            const response = await fetch('/api/pengaduan-publik');
            const data = await response.json();

            if (data.length === 0) {
                list.innerHTML = `<div class="col-span-full text-center py-20"><p class="text-slate-400">Belum ada laporan publik tersedia.</p></div>`;
                return;
            }

            list.innerHTML = data.map(r => {
                const statusColor = r.status_laporan === 'selesai' ? 'bg-green-100 text-green-600' : (r.status_laporan === 'diproses' ? 'bg-amber-100 text-amber-600' : 'bg-slate-100 text-slate-500');
                const fotoUrl = r.foto_bukti ? `/storage/${r.foto_bukti}` : null;

                return `
            <div class="bg-white p-8 rounded-[2rem] card-shadow border border-slate-50 hover:border-sky-200 transition">
                <div class="flex justify-between items-start mb-4">
                    <span class="px-3 py-1 bg-sky-50 text-sky-500 text-[10px] font-bold uppercase rounded-full tracking-wider">${r.category?.nama_kategori || 'Kategori Umum'}</span>
                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase ${statusColor}">${r.status_laporan}</span>
                </div>
                ${fotoUrl ? `
                <div class="mb-4 overflow-hidden rounded-2xl border border-slate-100 aspect-video">
                    <img src="${fotoUrl}" class="w-full h-full object-cover" alt="Bukti Laporan">
                </div>
                ` : ''}
                <h3 class="text-xl font-bold text-slate-900 mb-3">${r.judul_pengaduan}</h3>
                <div class="flex items-center gap-3 text-slate-400 text-xs mt-6 pt-6 border-t border-slate-50">
                    <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg> ${r.lokasi_kejadian}</span>
                    <span>•</span>
                    <span>${new Date(r.created_at).toLocaleDateString('id-ID')}</span>
                </div>
            </div>`;
            }).join('');
        } catch (error) {
            console.error('Error:', error);
            list.innerHTML = `<div class="col-span-full text-center py-20 text-red-400">Gagal memuat data.</div>`;
        }
    });
</script>
@endsection