<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pengaduan Masyarakat</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        'elapor': {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FAFCFF;
        }

        .hero-gradient {
            background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 30%, #f0f9ff 70%, #ffffff 100%);
        }

        .card-shadow {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        }

        .card-shadow-sm {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        }

        .stat-card {
            background: linear-gradient(135deg, #f0f9ff 0%, #ffffff 100%);
            border: 1px solid #e0f2fe;
        }

        .cta-gradient {
            background: linear-gradient(135deg, #0ea5e9 0%, #38bdf8 50%, #7dd3fc 100%);
        }

        .step-icon {
            background: linear-gradient(135deg, #0ea5e9 0%, #38bdf8 100%);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }

        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
    </style>
    @yield('styles')
</head>

<body class="text-gray-800">
    <nav class="bg-white/90 backdrop-blur-lg sticky top-0 z-50 border-b border-gray-100/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-gradient-to-br from-elapor-500 to-elapor-400 rounded-lg flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight text-gray-900">E-Lapor</span>
                </div>
                <div id="public-links" class="hidden md:flex space-x-8 text-sm font-medium text-gray-600">
                    <a href="/" class="hover:text-elapor-500 transition py-1 border-b-2 border-transparent hover:border-elapor-400">Beranda</a>
                    <a href="/tentang" class="hover:text-elapor-500 transition py-1 border-b-2 border-transparent hover:border-elapor-400">Tentang</a>
                    <a href="/cara-melapor" class="hover:text-elapor-500 transition py-1 border-b-2 border-transparent hover:border-elapor-400">Cara Melapor</a>
                    <a href="/daftar-pengaduan" class="hover:text-elapor-500 transition py-1 border-b-2 border-transparent hover:border-elapor-400">Daftar Pengaduan</a>
                </div>
                <div class="flex items-center space-x-4" id="nav-auth-buttons">
                    <!-- Guest Buttons -->
                    <div id="guest-buttons" class="flex items-center space-x-3">
                        <a href="/login" class="text-sm font-semibold text-gray-600 hover:text-elapor-600 transition px-4 py-2">Masuk</a>
                        <a href="/register" class="bg-gradient-to-r from-elapor-500 to-elapor-400 text-white px-6 py-2.5 rounded-full text-sm font-bold hover:from-elapor-600 hover:to-elapor-500 transition shadow-md shadow-elapor-200">Daftar</a>
                    </div>
                    <!-- User Buttons -->
                    <div id="user-buttons" class="hidden flex items-center space-x-4">
                        <div class="flex flex-col items-end mr-2">
                            <span id="nav-user-name" class="text-[10px] font-bold text-slate-900 leading-none mb-1">...</span>
                            <span id="nav-role-badge" class="px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-widest leading-none">...</span>
                        </div>
                        <a id="dashboard-link" href="/dashboard" class="text-sm font-bold text-elapor-500 hover:text-elapor-600 transition">Buat Laporan</a>
                        <button onclick="globalLogout()" class="text-sm font-semibold text-red-500 hover:text-red-600 transition">Keluar</button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <script>
        function checkGlobalAuth() {
            const token = localStorage.getItem('access_token');
            const user = JSON.parse(localStorage.getItem('user'));
            const path = window.location.pathname;

            const publicLinks = document.getElementById('public-links');
            const guestButtons = document.getElementById('guest-buttons');
            const userButtons = document.getElementById('user-buttons');
            const dashboardLink = document.getElementById('dashboard-link');
            const navUserName = document.getElementById('nav-user-name');
            const navRoleBadge = document.getElementById('nav-role-badge');

            if (token && user) {
                // User is logged in
                if (publicLinks) publicLinks.classList.add('hidden');
                if (guestButtons) guestButtons.classList.add('hidden');
                if (userButtons) userButtons.classList.remove('hidden');

                // Update Profile Info in Nav
                if (navUserName) navUserName.textContent = user.name;
                if (navRoleBadge) {
                    navRoleBadge.textContent = user.role === 'admin' ? 'ADMINISTRATOR' : 'MASYARAKAT';
                    navRoleBadge.className = user.role === 'admin' ?
                        'px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-widest leading-none bg-indigo-600 text-white shadow-sm' :
                        'px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-widest leading-none bg-sky-100 text-sky-600';
                }

                // Set correct dashboard link and text
                if (dashboardLink) {
                    dashboardLink.href = user.role === 'admin' ? '/dashboard/admin' : '/dashboard';
                    dashboardLink.textContent = user.role === 'admin' ? 'Manajemen Laporan' : 'Buat Laporan';
                    dashboardLink.className = user.role === 'admin' ?
                        'text-sm font-bold text-indigo-600 hover:text-indigo-700 transition' :
                        'text-sm font-bold text-sky-500 hover:text-sky-600 transition';
                }

                // Redirect away from login/register
                if (path === '/login' || path === '/register') {
                    window.location.href = user.role === 'admin' ? '/dashboard/admin' : '/dashboard';
                }
            } else {
                // User is NOT logged in
                if (publicLinks) publicLinks.classList.remove('hidden');
                if (guestButtons) guestButtons.classList.remove('hidden');
                if (userButtons) userButtons.classList.add('hidden');

                // Redirect to login if trying to access dashboard
                if (path.startsWith('/dashboard')) {
                    window.location.href = '/login';
                }
            }
        }

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

        // Run immediately
        checkGlobalAuth();
    </script>

    <main>
        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-100 py-12">
        <div class="max-w-7xl mx-auto px-4 text-center md:text-left grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-lg font-extrabold mb-4 text-gray-900">E-Lapor</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Platform resmi laporan masyarakat untuk mewujudkan lingkungan yang lebih baik, transparan, dan teratur.</p>
            </div>
            <div>
                <h4 class="font-bold mb-4 text-gray-900">Tautan Penting</h4>
                <ul class="text-sm text-gray-500 space-y-2">
                    <li><a href="#" class="hover:text-elapor-500 transition">Syarat & Ketentuan</a></li>
                    <li><a href="#" class="hover:text-elapor-500 transition">Kebijakan Privasi</a></li>
                    <li><a href="#" class="hover:text-elapor-500 transition">Kontak Kami</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-4 text-gray-900">Hubungi Kami</h4>
                <p class="text-sm text-gray-500 italic">"Suara Anda adalah langkah awal perubahan."</p>
                <p class="text-sm text-gray-600 mt-2">support@elapor.go.id</p>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 mt-8 pt-8 border-t border-gray-100 text-center text-xs text-gray-400">
            &copy; 2026 E-Lapor Sistem Pengaduan Masyarakat. All rights reserved.
        </div>
    </footer>

    @yield('scripts')
</body>

</html>