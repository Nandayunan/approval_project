<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - PT. XYZ Approval System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #1e40af;
            --primary-dark: #1e3a8a;
            --primary-light: #3b82f6;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #06b6d4;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar-active {
            background-color: rgba(59, 130, 246, 0.1);
            border-right: 3px solid #3b82f6;
        }

        .btn-primary {
            @apply bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2;
        }

        .btn-secondary {
            @apply bg-gray-300 hover:bg-gray-400 text-gray-900 px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2;
        }

        .btn-success {
            @apply bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2;
        }

        .btn-danger {
            @apply bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2;
        }

        .card {
            @apply bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 border border-gray-100;
        }

        .form-input {
            @apply w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 bg-white text-gray-900;
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-blue-900 text-white shadow-lg overflow-y-auto hidden lg:flex lg:flex-col">
            <div class="p-6 border-b border-blue-800">
                <div class="flex items-center gap-2">
                    <i class="fas fa-check-square text-2xl"></i>
                    <div>
                        <h1 class="text-lg font-bold">PT. XYZ</h1>
                        <p class="text-xs text-blue-200">Approval System</p>
                    </div>
                </div>
            </div>

            <!-- User Profile -->
            <div class="p-4 bg-blue-800">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-blue-200">{{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="p-4 space-y-2">
                @auth
                    @if (auth()->user()->role === 'supplier')
                        <a href="{{ route('supplier.dashboard') }}"
                            class="nav-link sidebar-active block px-4 py-2 rounded-lg {{ request()->routeIs('supplier.dashboard') ? 'sidebar-active' : 'hover:bg-blue-800' }} transition">
                            <i class="fas fa-chart-line w-5"></i> Dashboard
                        </a>
                        <a href="{{ route('supplier.packaging-forms') }}"
                            class="nav-link block px-4 py-2 rounded-lg {{ request()->routeIs('supplier.packaging*') ? 'sidebar-active' : 'hover:bg-blue-800' }} transition">
                            <i class="fas fa-box w-5"></i> Pengemasan
                        </a>
                        <a href="{{ route('supplier.resin-forms') }}"
                            class="nav-link block px-4 py-2 rounded-lg {{ request()->routeIs('supplier.resin*') ? 'sidebar-active' : 'hover:bg-blue-800' }} transition">
                            <i class="fas fa-flask-vial w-5"></i> Resin
                        </a>
                        <a href="{{ route('supplier.film-forms') }}"
                            class="nav-link block px-4 py-2 rounded-lg {{ request()->routeIs('supplier.film*') ? 'sidebar-active' : 'hover:bg-blue-800' }} transition">
                            <i class="fas fa-film w-5"></i> Film
                        </a>
                    @elseif(auth()->user()->role === 'security')
                        <a href="{{ route('security.dashboard') }}"
                            class="nav-link block px-4 py-2 rounded-lg {{ request()->routeIs('security.dashboard') ? 'sidebar-active' : 'hover:bg-blue-800' }} transition">
                            <i class="fas fa-shield-alt w-5"></i> Dashboard
                        </a>
                        <a href="{{ route('security.pending-approvals') }}"
                            class="nav-link block px-4 py-2 rounded-lg {{ request()->routeIs('security.pending*') ? 'sidebar-active' : 'hover:bg-blue-800' }} transition">
                            <i class="fas fa-check-circle w-5"></i> Persetujuan
                        </a>
                    @elseif(auth()->user()->role === 'export_import')
                        <a href="{{ route('export_import.dashboard') }}"
                            class="nav-link block px-4 py-2 rounded-lg {{ request()->routeIs('export_import.dashboard') ? 'sidebar-active' : 'hover:bg-blue-800' }} transition">
                            <i class="fas fa-globe w-5"></i> Dashboard
                        </a>
                        <a href="{{ route('export_import.pending-approvals') }}"
                            class="nav-link block px-4 py-2 rounded-lg {{ request()->routeIs('export_import.pending*') ? 'sidebar-active' : 'hover:bg-blue-800' }} transition">
                            <i class="fas fa-check-circle w-5"></i> Persetujuan
                        </a>
                    @elseif(auth()->user()->role === 'warehouse')
                        <a href="{{ route('warehouse.dashboard') }}"
                            class="nav-link block px-4 py-2 rounded-lg {{ request()->routeIs('warehouse.dashboard') ? 'sidebar-active' : 'hover:bg-blue-800' }} transition">
                            <i class="fas fa-warehouse w-5"></i> Dashboard
                        </a>
                        <a href="{{ route('warehouse.pending-approvals') }}"
                            class="nav-link block px-4 py-2 rounded-lg {{ request()->routeIs('warehouse.pending*') ? 'sidebar-active' : 'hover:bg-blue-800' }} transition">
                            <i class="fas fa-hourglass-half w-5"></i> Menunggu
                        </a>
                        <a href="{{ route('warehouse.approved-forms') }}"
                            class="nav-link block px-4 py-2 rounded-lg {{ request()->routeIs('warehouse.approved*') ? 'sidebar-active' : 'hover:bg-blue-800' }} transition">
                            <i class="fas fa-check-double w-5"></i> Tersetujui
                        </a>
                    @endif
                @endauth
            </nav>

            <!-- Logout Button -->
            <div class="mt-auto p-4 border-t border-blue-800">
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg transition duration-200 hover:shadow-md">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation (Mobile) -->
            <nav class="bg-white shadow-sm border-b border-gray-200 lg:hidden">
                <div class="px-4 py-3 flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check-square text-blue-600 text-xl"></i>
                        <span class="font-bold text-gray-900">PT. XYZ</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-700">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </nav>

            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
                    <!-- Breadcrumb -->
                    @if (View::exists('partials.breadcrumb'))
                        @include('partials.breadcrumb')
                    @endif

                    <!-- Flash Messages -->
                    @if ($message = Session::get('success'))
                        <div
                            class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg flex items-start gap-3">
                            <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
                            <div>
                                <h3 class="font-semibold">Berhasil!</h3>
                                <p class="text-sm">{{ $message }}</p>
                            </div>
                        </div>
                    @endif

                    @if ($message = Session::get('error'))
                        <div
                            class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg flex items-start gap-3">
                            <i class="fas fa-exclamation-circle text-red-600 mt-0.5"></i>
                            <div>
                                <h3 class="font-semibold">Terjadi Kesalahan!</h3>
                                <p class="text-sm">{{ $message }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Page Content -->
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 text-center py-3 text-sm border-t border-gray-800">
        <p>&copy; 2026 PT. XYZ Approval System. All rights reserved.</p>
    </footer>

    <script>
        // Toast notifications auto-hide
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('[role="alert"]');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 5000);
            });
        });
    </script>
</body>

</html>
