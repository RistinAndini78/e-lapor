@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center gradient-bg px-4">
    <div class="max-w-md w-full bg-white rounded-[2.5rem] p-10 card-shadow border border-slate-50">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-slate-900 mb-2">Selamat Datang</h2>
            <p class="text-slate-400 text-sm">Masuk untuk mengelola laporan pengaduan Anda.</p>
        </div>

        <form id="loginForm" class="space-y-6">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 ml-1">Email</label>
                <input type="email" name="email" required class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-sky-100 focus:border-sky-300 transition outline-none" placeholder="anda@contoh.com">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 ml-1">Password</label>
                <input type="password" name="password" required class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-sky-100 focus:border-sky-300 transition outline-none" placeholder="••••••••">
            </div>
            <button type="submit" class="w-full bg-primary-blue text-white py-4 rounded-2xl font-bold hover:bg-sky-400 transition card-shadow">
                Masuk Sekarang
            </button>
        </form>

        <div class="mt-8 text-center">
            <p class="text-sm text-slate-400">Belum punya akun? <a href="/register" class="text-sky-500 font-bold hover:underline">Daftar di sini</a></p>
        </div>
    </div>
</div>

<script>
    document.getElementById('loginForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData.entries());

        try {
            const response = await fetch('/api/login', {
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

                // Redirect based on role
                if (result.user.role === 'admin') {
                    window.location.href = '/dashboard/admin';
                } else {
                    window.location.href = '/dashboard';
                }
            } else {
                alert(result.error || 'Login gagal. Periksa kembali email dan password Anda.');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });
</script>
@endsection