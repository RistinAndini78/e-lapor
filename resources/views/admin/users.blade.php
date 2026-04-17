@extends('layouts.admin')

@section('styles')
<style>
    .user-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .user-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
    }
</style>
@endsection

@section('content')
<div class="mb-12 flex justify-between items-end">
    <div>
        <h2 class="text-3xl font-black text-slate-800 tracking-tight">Manajemen Pengguna</h2>
        <p class="text-slate-400 text-sm mt-1">Kelola hak akses dan profil administrator serta masyarakat.</p>
    </div>
    <button onclick="openUserModal()" class="bg-indigo-600 text-white px-8 py-4 rounded-2xl font-black text-sm hover:bg-indigo-700 transition shadow-lg shadow-indigo-600/20 flex items-center gap-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Tambah Pengguna Baru
    </button>
</div>

<!-- User Table Card -->
<div class="glass-card rounded-[3rem] shadow-xl border border-slate-200/50 overflow-hidden">
    <div class="p-10 border-b border-slate-100 flex justify-between items-center">
        <h3 class="font-black text-slate-800 text-lg">Daftar Seluruh Pengguna</h3>
        <input type="text" id="userSearch" placeholder="Cari nama atau email..." class="bg-slate-50 border border-slate-200 rounded-2xl px-6 py-3 text-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition outline-none w-80">
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-indigo-50 text-indigo-600 font-black uppercase text-[10px] tracking-widest border-b border-slate-100">
                    <th class="px-10 py-6">Profil Pengguna</th>
                    <th class="px-10 py-6">Hak Akses</th>
                    <th class="px-10 py-6">Terdaftar Pada</th>
                    <th class="px-10 py-6 text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody id="userList" class="divide-y divide-slate-100">
                <!-- Data akan dimuat via JS -->
                <tr>
                    <td colspan="4" class="px-10 py-20 text-center">
                        <div class="animate-pulse flex flex-col items-center gap-4">
                            <div class="w-12 h-12 bg-slate-100 rounded-full"></div>
                            <div class="h-4 w-48 bg-slate-100 rounded"></div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    document.getElementById('pageTitle').innerText = 'Manajemen Pengguna';

    let allUsers = [];

    async function fetchUsers() {
        try {
            const token = localStorage.getItem('access_token');
            const res = await fetch('/api/users', {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });
            allUsers = await res.json();
            renderUsers();
        } catch (err) {
            console.error('Gagal memuat pengguna', err);
        }
    }

    function renderUsers(filter = '') {
        const list = document.getElementById('userList');
        const term = filter.toLowerCase();
        const filtered = allUsers.filter(u =>
            u.name.toLowerCase().includes(term) ||
            u.email.toLowerCase().includes(term)
        );

        if (filtered.length === 0) {
            list.innerHTML = `<tr><td colspan="4" class="px-10 py-20 text-center text-slate-400 font-bold uppercase text-xs tracking-widest">Tidak ada pengguna ditemukan</td></tr>`;
            return;
        }

        list.innerHTML = filtered.map(u => `
            <tr class="hover:bg-slate-50 transition">
                <td class="px-10 py-8">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center font-black text-indigo-600 border border-indigo-100 shadow-sm">
                            ${u.name.charAt(0)}
                        </div>
                        <div>
                            <div class="font-black text-slate-800 text-sm">${u.name}</div>
                            <div class="text-[10px] text-slate-400 font-medium lowercase tracking-wide">${u.email}</div>
                        </div>
                    </div>
                </td>
                <td class="px-10 py-8">
                    <span class="px-4 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest ${u.role === 'admin' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-500'}">
                        ${u.role}
                    </span>
                </td>
                <td class="px-10 py-8 font-bold text-slate-400 text-xs">
                    ${new Date(u.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}
                </td>
                <td class="px-10 py-8 text-center">
                    <div class="flex items-center justify-center gap-2">
                        <button onclick="editUser(${u.id})" class="p-3 bg-slate-50 text-slate-400 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 transition border border-slate-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </button>
                        <button onclick="deleteUser(${u.id})" class="p-3 bg-slate-50 text-slate-400 rounded-xl hover:bg-red-50 hover:text-red-500 transition border border-slate-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </td>
            </tr>
        `).join('');
    }

    async function deleteUser(id) {
        if (!confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) return;
        try {
            const token = localStorage.getItem('access_token');
            const res = await fetch(`/api/users/${id}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });
            if (res.ok) {
                allUsers = allUsers.filter(u => u.id !== id);
                renderUsers();
            }
        } catch (err) {
            alert('Gagal menghapus pengguna');
        }
    }

    document.getElementById('userSearch').addEventListener('input', (e) => renderUsers(e.target.value));

    fetchUsers();

    let editingUserId = null;

    function openUserModal(id = null) {
        editingUserId = id;
        const modal = document.getElementById('userModal');
        const title = document.getElementById('modalTitle');
        const pwdLabel = document.getElementById('passwordLabel');
        const submitBtn = document.getElementById('submitUserBtn');

        if (id) {
            const user = allUsers.find(u => u.id === id);
            title.innerText = 'Perbarui Data Pengguna';
            pwdLabel.innerText = 'Kata Sandi (Kosongkan jika tidak diganti)';
            submitBtn.innerText = 'Simpan Perubahan';

            document.getElementById('userNameInput').value = user.name;
            document.getElementById('userEmailInput').value = user.email;
            document.getElementById('userRoleSelect').value = user.role;
            document.getElementById('userPasswordInput').required = false;
        } else {
            title.innerText = 'Tambah Pengguna Baru';
            pwdLabel.innerText = 'Kata Sandi';
            submitBtn.innerText = 'Simpan Pengguna';
            document.getElementById('addUserForm').reset();
            document.getElementById('userPasswordInput').required = true;
        }

        modal.classList.remove('hidden');
    }

    function editUser(id) {
        openUserModal(id);
    }

    function closeUserModal() {
        document.getElementById('userModal').classList.add('hidden');
        document.getElementById('addUserForm').reset();
        editingUserId = null;
    }

    document.getElementById('addUserForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData.entries());

        // Remove empty password if editing
        if (editingUserId && !data.password) {
            delete data.password;
        }

        try {
            const token = localStorage.getItem('access_token');
            const url = editingUserId ? `/api/users/${editingUserId}` : '/api/users';
            const method = editingUserId ? 'PUT' : 'POST';

            const res = await fetch(url, {
                method: method,
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            if (res.ok) {
                alert(editingUserId ? 'Data pengguna berhasil diperbarui!' : 'Pengguna baru berhasil ditambahkan!');
                closeUserModal();
                fetchUsers();
            } else {
                const errors = await res.json();
                alert('Gagal: ' + JSON.stringify(errors));
            }
        } catch (err) {
            alert('Kesalahan sistem saat menyimpan data');
        }
    });
</script>

<!-- User Modal -->
<div id="userModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeUserModal()"></div>
    <div class="bg-white rounded-[2rem] w-full max-w-lg overflow-hidden shadow-2xl relative">
        <div class="p-8">
            <h3 class="text-xl font-black text-slate-800 mb-6" id="modalTitle">Tambah Pengguna Baru</h3>
            <form id="addUserForm" class="space-y-4">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nama Lengkap</label>
                    <input type="text" name="name" id="userNameInput" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 text-sm focus:ring-4 focus:ring-indigo-500/10 outline-none">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Alamat Email</label>
                    <input type="email" name="email" id="userEmailInput" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 text-sm focus:ring-4 focus:ring-indigo-500/10 outline-none">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2" id="passwordLabel">Kata Sandi</label>
                    <input type="password" name="password" id="userPasswordInput" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 text-sm focus:ring-4 focus:ring-indigo-500/10 outline-none">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Role / Hak Akses</label>
                    <select name="role" id="userRoleSelect" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 text-sm focus:ring-4 focus:ring-indigo-500/10 outline-none">
                        <option value="masyarakat">Masyarakat</option>
                        <option value="admin">Administrator</option>
                    </select>
                </div>
                <button type="submit" id="submitUserBtn" class="w-full bg-indigo-600 text-white py-4 rounded-2xl font-black text-sm hover:bg-indigo-700 transition mt-4">Simpan Pengguna</button>
            </form>
        </div>
    </div>
</div>
@endsection