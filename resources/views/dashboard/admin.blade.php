@extends('layouts.admin')

@section('content')
<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
    <div class="glass-card p-10 rounded-[2.5rem] border-t-4 border-indigo-500 shadow-2xl overflow-hidden relative group">
        <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition">
            <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 10h-4v4h-2v-4H7v-2h4V7h2v4h4v2z" />
            </svg>
        </div>
        <span class="text-indigo-600 font-bold uppercase tracking-widest text-[10px]">Volume Database</span>
        <h3 class="text-5xl font-black text-slate-900 mt-4" id="statTotal">0</h3>
        <p class="text-slate-400 text-xs mt-2">Total aduan terdaftar di sistem</p>
    </div>

    <div class="glass-card p-10 rounded-[2.5rem] border-t-4 border-amber-500 shadow-2xl overflow-hidden relative group">
        <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition">
            <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
            </svg>
        </div>
        <span class="text-amber-600 font-bold uppercase tracking-widest text-[10px]">Menunggu Verifikasi</span>
        <h3 class="text-5xl font-black text-slate-900 mt-4" id="statPending">0</h3>
        <p class="text-slate-400 text-xs mt-2">Menunggu tindakan verifikasi</p>
    </div>

    <div class="glass-card p-10 rounded-[2.5rem] border-t-4 border-emerald-500 shadow-2xl overflow-hidden relative group">
        <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition">
            <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24">
                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
            </svg>
        </div>
        <span class="text-emerald-600 font-bold uppercase tracking-widest text-[10px]">Insiden Terselesaikan</span>
        <h3 class="text-5xl font-black text-slate-900 mt-4" id="statSelesai">0</h3>
        <p class="text-slate-400 text-xs mt-2">Kasus tuntas dalam pengawasan</p>
    </div>
</div>

<!-- Main Table Card -->
<div class="glass-card rounded-[3rem] shadow-xl border border-slate-200/50 overflow-hidden">
    <div class="p-10 border-b border-slate-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Manajemen Alur Kerja Pengaduan</h2>
            <p class="text-slate-400 text-xs mt-1">Gunakan panel ini untuk memonitor dan mengubah status laporan masyarakat secara real-time.</p>
        </div>
        <div class="relative w-full md:w-80">
            <input type="text" id="searchInput" placeholder="Cari pelapor atau judul..." class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition outline-none text-slate-700">
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-indigo-50 text-indigo-600 font-black uppercase text-[10px] tracking-[0.2em] border-b border-slate-100">
                    <th class="px-10 py-6">ID / Pelapor</th>
                    <th class="px-10 py-6">Subjek Aduan</th>
                    <th class="px-10 py-6">Lokasi Kejadian</th>
                    <th class="px-10 py-6 text-center">Data Foto</th>
                    <th class="px-10 py-6">Status Laporan</th>
                    <th class="px-10 py-6 text-center">Kontrol Status</th>
                </tr>
            </thead>
            <tbody id="adminLaporanList" class="divide-y divide-slate-100">
                <!-- Dynamic content -->
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const token = localStorage.getItem('access_token');
    const currentUser = JSON.parse(localStorage.getItem('user'));

    if (!token || (currentUser && currentUser.role !== 'admin')) {
        window.location.href = '/login';
    }

    document.getElementById('pageTitle').textContent = 'Pusat Kendali Operasional';

    let allReports = [];

    document.addEventListener('DOMContentLoaded', fetchAllReports);
    document.getElementById('searchInput').addEventListener('input', (e) => {
        renderReports(e.target.value);
    });

    async function fetchAllReports() {
        try {
            const response = await fetch('/api/pengaduan', {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });
            allReports = await response.json();

            // Update Stats
            document.getElementById('statTotal').textContent = allReports.length;
            document.getElementById('statPending').textContent = allReports.filter(r => r.status_laporan === 'menunggu').length;
            document.getElementById('statSelesai').textContent = allReports.filter(r => r.status_laporan === 'selesai').length;

            renderReports();
        } catch (error) {
            console.error('Error:', error);
        }
    }

    function renderReports(filter = '') {
        const list = document.getElementById('adminLaporanList');
        const term = filter.toLowerCase();

        const filtered = allReports.filter(r =>
            r.user.name.toLowerCase().includes(term) ||
            r.judul_pengaduan.toLowerCase().includes(term) ||
            r.lokasi_kejadian.toLowerCase().includes(term)
        );

        list.innerHTML = filtered.map(r => {
            const statusStyle = r.status_laporan === 'selesai' ?
                'bg-emerald-50 text-emerald-600 border border-emerald-100' :
                (r.status_laporan === 'diproses' ? 'bg-amber-50 text-amber-600 border border-amber-100' : 'bg-slate-50 text-slate-500 border border-slate-100');

            const fotoUrl = r.foto_bukti ? `/storage/${r.foto_bukti}` : null;

            return `
            <tr class="hover:bg-slate-50 transition group">
                <td class="px-10 py-8">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center font-bold text-slate-500 border border-slate-100">
                            ${r.id}
                        </div>
                        <div>
                            <div class="font-black text-slate-800 text-sm">${r.user.name}</div>
                            <div class="text-[10px] text-slate-400 font-medium lowercase tracking-wide">${r.user.email}</div>
                        </div>
                    </div>
                </td>
                <td class="px-10 py-8">
                    <div class="font-bold text-indigo-600 text-sm mb-1">${r.judul_pengaduan}</div>
                    <span class="text-[10px] px-2 py-0.5 bg-slate-50 text-slate-400 rounded uppercase font-black border border-slate-100">${r.category?.nama_kategori || 'TANPA KATEGORI'}</span>
                </td>
                <td class="px-10 py-8 text-slate-500 text-xs font-semibold">
                    <div class="flex items-center gap-2">
                        <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                        ${r.lokasi_kejadian}
                    </div>
                </td>
                <td class="px-10 py-8 text-center">
                    ${fotoUrl ? `
                        <a href="${fotoUrl}" target="_blank" class="block group/img relative">
                            <img src="${fotoUrl}" class="w-12 h-12 object-cover rounded-2xl border border-slate-100 shadow-lg group-hover/img:scale-110 transition mx-auto">
                            <div class="absolute inset-0 bg-indigo-600/10 rounded-2xl opacity-0 group-hover/img:opacity-100 flex items-center justify-center transition">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </div>
                        </a>
                    ` : '<span class="text-slate-300 text-[10px] font-black uppercase tracking-tighter">Tidak Ada Foto</span>'}
                </td>
                <td class="px-10 py-8">
                    <span class="px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest ${statusStyle}">${r.status_laporan}</span>
                </td>
                <td class="px-10 py-8 text-center">
                    <select onchange="updateStatus(${r.id}, this.value)" class="bg-indigo-50 border border-indigo-100 rounded-2xl px-5 py-3 text-[11px] font-black outline-none focus:ring-4 focus:ring-indigo-100 transition text-indigo-600 cursor-pointer shadow-sm hover:group-hover:bg-indigo-100 uppercase tracking-widest">
                        <option value="menunggu" ${r.status_laporan === 'menunggu' ? 'selected' : ''}>Tandai: MENUNGGU</option>
                        <option value="diproses" ${r.status_laporan === 'diproses' ? 'selected' : ''}>Tandai: DIPROSES</option>
                        <option value="selesai" ${r.status_laporan === 'selesai' ? 'selected' : ''}>Tandai: SELESAI</option>
                    </select>
                </td>
            </tr>`;
        }).join('');
    }

    async function updateStatus(id, newStatus) {
        const response = await fetch(`/api/pengaduan/${id}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                status_laporan: newStatus
            })
        });

        if (response.ok) {
            fetchAllReports();
        } else {
            alert('Gagal memperbarui status otoritas.');
        }
    }
</script>
@endsection