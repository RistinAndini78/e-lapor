@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900">Pusat Laporan Warga</h1>
                <div class="flex items-center gap-2 mt-1">
                    <span class="bg-primary-blue text-white text-[10px] font-bold px-2 py-0.5 rounded shadow-sm">MASYARAKAT</span>
                    <p class="text-slate-500">Halo <span id="userName" class="font-bold text-sky-500">...</span>, kelola aduan Anda di sini.</p>
                </div>
            </div>
            <button onclick="globalLogout()" class="text-red-500 font-bold hover:bg-red-50 px-6 py-3 rounded-2xl transition border border-red-100">Keluar</button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Form Buat Laporan -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-[2rem] p-8 card-shadow sticky top-24 border border-slate-50">
                    <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 bg-sky-100 text-sky-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </span>
                        <span id="formTitle">Buat Pengaduan</span>
                    </h2>
                    <form id="pengaduanForm" class="space-y-5">
                        <div id="formFields">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-2 ml-1">Judul Laporan</label>
                                <input type="text" name="judul_pengaduan" required class="w-full px-5 py-4 bg-slate-50 rounded-2xl outline-none focus:ring-4 focus:ring-sky-100 transition" placeholder="Contoh: Jalan Berlubang">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-2 mt-4 ml-1">Kategori</label>
                                <select name="category_id" id="categorySelect" required class="w-full px-5 py-4 bg-slate-50 rounded-2xl outline-none focus:ring-4 focus:ring-sky-100 transition">
                                    <option value="">Pilih Kategori</option>
                                    <!-- Dynamic categories -->
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-2 mt-4 ml-1">Lokasi Kejadian</label>
                                <input type="text" name="lokasi_kejadian" required class="w-full px-5 py-4 bg-slate-50 rounded-2xl outline-none focus:ring-4 focus:ring-sky-100 transition" placeholder="Alamat lengkap">
                            </div>
                            <div id="fotoInputContainer">
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-2 mt-4 ml-1">Foto Bukti</label>
                                <input type="file" name="foto_bukti" accept="image/*" class="w-full px-5 py-4 bg-slate-50 rounded-2xl outline-none focus:ring-4 focus:ring-sky-100 transition file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-sky-50 file:text-sky-600 hover:file:bg-sky-100">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-2 mt-4 ml-1">Deskripsi Masalah</label>
                                <textarea name="deskripsi_masalah" rows="4" required class="w-full px-5 py-4 bg-slate-50 rounded-2xl outline-none focus:ring-4 focus:ring-sky-100 transition" placeholder="Jelaskan secara detail..."></textarea>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <button type="submit" id="submitBtn" class="flex-1 bg-primary-blue text-white py-4 rounded-2xl font-bold hover:bg-sky-400 transition card-shadow mt-4">Kirim Laporan</button>
                            <button type="button" id="cancelBtn" onclick="cancelEdit()" class="flex-1 bg-slate-100 text-slate-500 py-4 rounded-2xl font-bold hover:bg-slate-200 transition mt-4 hidden">Batal</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- List Laporan -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-[2rem] p-8 card-shadow border border-slate-50">
                    <h2 class="text-xl font-bold mb-8">Riwayat Laporan Saya</h2>
                    <div id="laporanList" class="space-y-6">
                        <!-- Dynamic reports -->
                        <p class="text-slate-400 text-center py-10">Memuat laporan...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal (Glassmorphism) -->
<div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden opacity-0 transition-all duration-500">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-md" onclick="closeEditModal()"></div>
    <div class="bg-white/90 backdrop-blur-2xl rounded-[3rem] w-full max-w-2xl max-h-[90vh] overflow-y-auto overflow-x-hidden shadow-2xl border border-white/20 relative transform scale-95 transition-all duration-500" id="modalContainer">
        <!-- Decoration Container -->
        <div class="absolute inset-0 overflow-hidden rounded-[3rem] pointer-events-none">
            <div class="absolute top-0 right-0 w-64 h-64 bg-violet-600/10 rounded-full blur-3xl -mr-32 -mt-32"></div>
        </div>

        <div class="p-10 relative">
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-violet-600 rounded-2xl flex items-center justify-center shadow-lg shadow-violet-600/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-black text-slate-800 tracking-tight">Perbarui Aduan</h2>
                        <p class="text-slate-400 text-xs mt-1">Sempurnakan detail laporan Anda di sini.</p>
                    </div>
                </div>
                <button onclick="closeEditModal()" class="w-10 h-10 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center hover:bg-red-50 hover:text-red-500 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="editForm" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Judul Laporan</label>
                        <input type="text" name="judul_pengaduan" required class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl outline-none focus:ring-4 focus:ring-violet-500/10 focus:border-violet-600 transition font-bold text-slate-700">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Kategori</label>
                        <select name="category_id" id="editCategorySelect" required class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl outline-none focus:ring-4 focus:ring-violet-500/10 focus:border-violet-600 transition font-bold text-slate-700">
                            <!-- Categories copied from fetch -->
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Lokasi Kejadian</label>
                        <input type="text" name="lokasi_kejadian" required class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl outline-none focus:ring-4 focus:ring-violet-500/10 focus:border-violet-600 transition font-bold text-slate-700">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Deskripsi Masalah</label>
                        <textarea name="deskripsi_masalah" rows="4" required class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-3xl outline-none focus:ring-4 focus:ring-violet-500/10 focus:border-violet-600 transition font-bold text-slate-700"></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Update Foto (Biarkan kosong jika tidak diganti)</label>
                        <div class="flex items-center gap-6">
                            <div id="existingFotoPreview" class="w-24 h-24 rounded-2xl border border-slate-100 overflow-hidden hidden">
                                <img src="" class="w-full h-full object-cover">
                            </div>
                            <input type="file" name="foto_bukti" accept="image/*" class="flex-1 px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl outline-none focus:ring-4 focus:ring-violet-500/10 focus:border-violet-600 transition file:hidden font-semibold text-slate-500">
                        </div>
                    </div>
                </div>
                <div class="pt-4">
                    <button type="submit" class="w-full bg-violet-600 text-white py-5 rounded-[1.5rem] font-black text-sm uppercase tracking-[0.2em] hover:bg-violet-700 transition shadow-xl shadow-violet-600/30">Simpan Perubahan Aduan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const token = localStorage.getItem('access_token');
    const currentUser = JSON.parse(localStorage.getItem('user'));

    if (!token || (currentUser && currentUser.role !== 'masyarakat')) {
        window.location.href = '/login';
    }

    document.getElementById('userName').textContent = currentUser.name;

    // Load categories & reports on init
    document.addEventListener('DOMContentLoaded', () => {
        fetchCategories();
        fetchReports();
    });

    async function fetchCategories() {
        // We'll use a hardcoded fallback if API fails or just fetch
        const response = await fetch('/api/categories'); // Actually we need this endpoint too
        // For now manually or dummy
        const select = document.getElementById('categorySelect');
        [{
                id: 1,
                name: 'Fasilitas Publik'
            },
            {
                id: 2,
                name: 'Sanitasi'
            },
            {
                id: 3,
                name: 'Kesehatan'
            },
            {
                id: 4,
                name: 'Sosial'
            }
        ].forEach(cat => {
            select.innerHTML += `<option value="${cat.id}">${cat.name}</option>`;
        });
    }

    async function fetchReports() {
        const list = document.getElementById('laporanList');
        try {
            const response = await fetch('/api/pengaduan', {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });
            const reports = await response.json();

            if (reports.length === 0) {
                list.innerHTML = `<div class="text-center py-12"><img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" class="w-20 mx-auto opacity-20 mb-4"><p class="text-slate-400">Belum ada laporan yang dibuat.</p></div>`;
                return;
            }

            list.innerHTML = reports.map(r => {
                const statusColor = r.status_laporan === 'selesai' ? 'bg-green-100 text-green-600' : (r.status_laporan === 'diproses' ? 'bg-amber-100 text-amber-600' : 'bg-slate-100 text-slate-500');
                const isEditable = r.status_laporan === 'menunggu';
                const fotoUrl = r.foto_bukti ? `/storage/${r.foto_bukti}` : null;

                return `
            <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100 hover:border-sky-200 transition relative group">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-sky-400">${r.category?.nama_kategori || 'Kategori Umum'}</span>
                        <h4 class="text-lg font-bold text-slate-900">${r.judul_pengaduan}</h4>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="px-3 py-1 text-[10px] font-bold uppercase rounded-full ${statusColor}">${r.status_laporan}</span>
                        ${isEditable ? `
                            <button onclick='editLaporan(${JSON.stringify(r)})' class="p-2 bg-white border border-slate-100 rounded-lg text-sky-500 hover:bg-sky-50 transition shadow-sm opacity-0 group-hover:opacity-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>
                            <button onclick="hapusLaporan(${r.id})" class="p-2 bg-white border border-slate-100 rounded-lg text-red-500 hover:bg-red-50 transition shadow-sm opacity-0 group-hover:opacity-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        ` : ''}
                    </div>
                </div>
                ${fotoUrl ? `
                <div class="mb-4 overflow-hidden rounded-2xl border border-slate-100">
                    <img src="${fotoUrl}" class="w-full h-48 object-cover hover:scale-105 transition duration-500" alt="Bukti Laporan">
                </div>
                ` : ''}
                <p class="text-sm text-slate-500 leading-relaxed mb-4">${r.deskripsi_masalah}</p>
                <div class="flex items-center gap-4 text-xs text-slate-400">
                    <span class="flex items-center gap-1 font-medium"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg> ${r.lokasi_kejadian}</span>
                    <span class="flex items-center gap-1 font-medium"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg> ${new Date(r.created_at).toLocaleDateString('id-ID')}</span>
                </div>
            </div>`;
            }).join('');
        } catch (error) {
            console.error('Error:', error);
        }
    }

    let editingId = null;

    function editLaporan(report) {
        editingId = report.id;
        const modal = document.getElementById('editModal');
        const container = document.getElementById('modalContainer');
        const form = document.getElementById('editForm');

        // Fill Data
        form.querySelector('[name="judul_pengaduan"]').value = report.judul_pengaduan;
        form.querySelector('[name="category_id"]').innerHTML = document.getElementById('categorySelect').innerHTML;
        form.querySelector('[name="category_id"]').value = report.category_id;
        form.querySelector('[name="lokasi_kejadian"]').value = report.lokasi_kejadian;
        form.querySelector('[name="deskripsi_masalah"]').value = report.deskripsi_masalah;

        const preview = document.getElementById('existingFotoPreview');
        if (report.foto_bukti) {
            preview.classList.remove('hidden');
            preview.querySelector('img').src = `/storage/${report.foto_bukti}`;
        } else {
            preview.classList.add('hidden');
        }

        // Show Modal with Animation
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            container.classList.remove('scale-95');
        }, 10);
    }

    function closeEditModal() {
        const modal = document.getElementById('editModal');
        const container = document.getElementById('modalContainer');

        modal.classList.add('opacity-0');
        container.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            editingId = null;
            document.getElementById('editForm').reset();
        }, 500);
    }

    async function hapusLaporan(id) {
        if (!confirm('Apakah Anda yakin ingin menghapus laporan ini?')) return;

        const response = await fetch(`/api/pengaduan/${id}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${token}`
            }
        });

        if (response.ok) {
            alert('Laporan berhasil dihapus.');
            fetchReports();
        } else {
            alert('Gagal menghapus laporan.');
        }
    }

    document.getElementById('editForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        formData.append('_method', 'PATCH');

        const response = await fetch(`/api/pengaduan/${editingId}`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            body: formData
        });

        if (response.ok) {
            alert('Laporan berhasil diperbarui!');
            closeEditModal();
            fetchReports();
        } else {
            const err = await response.json();
            alert('Gagal: ' + JSON.stringify(err));
        }
    });

    document.getElementById('pengaduanForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);

        const response = await fetch('/api/pengaduan', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            body: formData
        });

        if (response.ok) {
            alert('Laporan berhasil dikirim!');
            e.target.reset();
            fetchReports();
        } else {
            const err = await response.json();
            alert('Gagal: ' + JSON.stringify(err));
        }
    });

    // logout() removed, using globalLogout() from layout
</script>
@endsection