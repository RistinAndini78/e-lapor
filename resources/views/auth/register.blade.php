@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center gradient-bg px-4 py-12">
    <div class="max-w-md w-full bg-white rounded-[2.5rem] p-10 card-shadow border border-slate-50">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-slate-900 mb-2">Buat Akun Baru</h2>
            <p class="text-slate-400 text-sm">Bergabunglah untuk mulai menyuarakan aspirasi Anda.</p>
        </div>

        <form id="registerForm" class="space-y-6">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 ml-1">Nama Lengkap</label>
                <input type="text" name="name" required class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-sky-100 focus:border-sky-300 transition outline-none" placeholder="Masukkan nama Anda">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 ml-1">Email</label>
                <input type="email" name="email" required class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-sky-100 focus:border-sky-300 transition outline-none" placeholder="anda@contoh.com">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 ml-1">Password</label>
                <input type="password" name="password" required class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-sky-100 focus:border-sky-300 transition outline-none" placeholder="Minimal 6 karakter">
            </div>
            <button type="submit" class="w-full bg-primary-blue text-white py-4 rounded-2xl font-bold hover:bg-sky-400 transition card-shadow">
                Daftar Sekarang
            </button>
        </form>

        <div class="mt-8 text-center">
            <p class="text-sm text-slate-400">Sudah punya akun? <a href="/login" class="text-sky-500 font-bold hover:underline">Masuk di sini</a></p>
        </div>
    </div>
</div>

<script>
    document.getElementById('registerForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData.entries());

        try {
            const response = await fetch('/api/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();
            if (response.ok) {
                localStorage.setItem('access_token', result.access_token);
                localStorage.setItem('user', JSON.stringify(result.user));
                alert('Registrasi berhasil!');
                window.location.href = '/dashboard';
            } else {
                alert(JSON.stringify(result) || 'Registrasi gagal. Coba data lain.');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });
</script>
@endsection