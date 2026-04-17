<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pengaduan - Pusat Kendali Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            /* Light Slate */
        }

        .sidebar-active {
            background: rgba(79, 70, 229, 0.05);
            color: #4f46e5;
            border-left: 4px solid #4f46e5;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .text-indigo-gradient {
            background: linear-gradient(to right, #818cf8, #c084fc);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
    @yield('styles')
</head>

<body class="text-slate-600">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-72 bg-white border-r border-slate-200 flex flex-col pt-8">
            <div class="px-8 mb-12 flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-600/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <span class="text-xl font-black text-slate-800 tracking-tighter">E -<span class="text-indigo-600">LAPOR</span></span>
            </div>

            <nav class="flex-1 space-y-2">
                <a href="/dashboard/admin" class="flex items-center gap-4 px-8 py-4 text-sm font-bold {{ request()->is('dashboard/admin') ? 'sidebar-active' : 'text-slate-500 hover:text-indigo-600 transition hover:bg-slate-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    Ringkasan Aduan
                </a>
                <a href="/dashboard/admin/users" class="flex items-center gap-4 px-8 py-4 text-sm font-bold {{ request()->is('dashboard/admin/users') ? 'sidebar-active' : 'text-slate-500 hover:text-indigo-600 transition hover:bg-slate-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15.21 17.166a8.205 8.205 0 00-13.433 0m14.358-5.108a8.205 8.205 0 00-13.433 0m14.358-5.108a8.205 8.205 0 0113.433 0M19 16.166a8.205 8.205 0 00-13.433 0"></path>
                    </svg>
                    Data Pengguna
                </a>
                <a href="/dashboard/admin/settings" class="flex items-center gap-4 px-8 py-4 text-sm font-bold {{ request()->is('dashboard/admin/settings') ? 'sidebar-active' : 'text-slate-500 hover:text-indigo-600 transition hover:bg-slate-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    </svg>
                    Setelan Sistem
                </a>
            </nav>

            <div class="p-8 mt-auto border-t border-slate-100">
                <button onclick="globalLogout()" class="flex items-center gap-4 text-red-500 hover:text-red-600 transition font-bold text-sm text-[11px] uppercase tracking-widest">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Keluar Sesi
                </button>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto bg-slate-50 relative">
            <!-- Topbar -->
            <header class="h-20 border-b border-slate-200 flex items-center justify-between px-12 sticky top-0 bg-white/80 backdrop-blur-xl z-20">
                <h2 id="pageTitle" class="text-xs font-black text-slate-600 uppercase tracking-[0.3em]">Ringkasan Dasbor</h2>
                <div class="flex items-center gap-6">
                    <div class="flex flex-col items-end">
                        <span id="nav-user-name" class="text-sm font-black text-slate-800 leading-none mb-1">...</span>
                        <span class="text-[9px] font-black text-indigo-600 uppercase tracking-widest bg-indigo-50 px-2 py-1 rounded">ADMINISTRATOR UTAMA</span>
                    </div>
                    <div class="w-10 h-10 bg-slate-100 rounded-full border border-slate-200 flex items-center justify-center overflow-hidden">
                        <img id="adminAvatar" src="https://api.dicebear.com/7.x/initials/svg?seed=Admin" alt="Admin">
                    </div>
                </div>
            </header>

            <div class="p-12">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        async function globalLogout() {
            const token = localStorage.getItem('access_token');
            if (token) {
                try {
                    await fetch('/api/logout', {
                        method: 'POST',
                        headers: {
                            'Authorization': `Bearer ${token}`
                        }
                    });
                } catch (e) {}
            }
            localStorage.clear();
            window.location.href = '/login';
        }

        const user = JSON.parse(localStorage.getItem('user'));
        if (user) {
            document.getElementById('nav-user-name').textContent = user.name;
        }
    </script>
    @yield('scripts')
</body>

</html>