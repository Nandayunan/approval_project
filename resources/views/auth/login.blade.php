<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PT. XYZ Approval System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>

<body class="login-container min-h-screen">
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <!-- Logo Card -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-full shadow-lg mb-4">
                    <i class="fas fa-check-double text-blue-600 text-2xl"></i>
                </div>
                <h1 class="text-4xl font-bold text-white">PT. XYZ</h1>
                <p class="text-blue-100 text-sm mt-2">Sistem Persetujuan Dokumen</p>
            </div>

            <!-- Login Form Card -->
            <div class="bg-white rounded-2xl shadow-2xl p-8 backdrop-blur">
                <h2 class="text-2xl font-bold text-gray-900 mb-1">Selamat Datang</h2>
                <p class="text-gray-600 text-sm mb-8">Masuk dengan akun Anda untuk melanjutkan</p>

                @if ($errors->any())
                    <div
                        class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg flex items-start gap-3">
                        <i class="fas fa-exclamation-circle text-red-600 mt-0.5 shrink-0"></i>
                        <div>
                            <h3 class="font-semibold text-sm mb-2">Login Gagal</h3>
                            <ul class="list-disc list-inside text-sm space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <!-- Form -->
                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-envelope text-blue-600 mr-2"></i>Email
                        </label>
                        <input type="email" name="email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('email') border-red-500 @enderror"
                            value="{{ old('email') }}" required autofocus placeholder="nama@perusahaan.com">
                        @error('email')
                            <p class="text-red-600 text-xs mt-1 flex items-center gap-1"><i
                                    class="fas fa-times-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-lock text-blue-600 mr-2"></i>Password
                        </label>
                        <input type="password" name="password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('password') border-red-500 @enderror"
                            required placeholder="••••••••">
                        @error('password')
                            <p class="text-red-600 text-xs mt-1 flex items-center gap-1"><i
                                    class="fas fa-times-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember"
                            class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                        <label for="remember" class="ml-2 text-sm text-gray-600">Ingat saya di perangkat ini</label>
                    </div>

                    <button type="submit"
                        class="w-full bg-linear-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 rounded-lg transition transform hover:scale-105 duration-200 flex items-center justify-center gap-2 shadow-lg">
                        <i class="fas fa-sign-in-alt"></i>
                        Masuk
                    </button>
                </form>

                <!-- Divider -->
                <div class="my-6 relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">atau</span>
                    </div>
                </div>

                <!-- Demo Accounts Info -->
                <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                    <p class="text-sm font-semibold text-gray-900 mb-3 flex items-center gap-2">
                        <i class="fas fa-user-circle text-blue-600"></i>
                        Akun Demo Tersedia
                    </p>
                    <ul class="text-xs text-gray-600 space-y-2">
                        <li>👤 <span class="font-mono">supplier@example.com</span></li>
                        <li>🔒 <span class="font-mono">password</span></li>
                    </ul>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center text-blue-100 text-sm">
                <p>&copy; 2026 PT. XYZ Approval System. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>

</html>
<p class="text-gray-600 text-sm">Belum punya akun? <a href="{{ route('register') }}"
        class="text-blue-600 hover:underline font-semibold">Daftar di sini</a></p>
</div>

<!-- Demo Accounts -->
<div class="mt-8 p-4 bg-blue-50 rounded-lg">
    <p class="text-xs font-semibold text-gray-700 mb-2">Demo Accounts:</p>
    <div class="space-y-1 text-xs text-gray-600">
        <p><strong>Supplier:</strong> supplier@example.com</p>
        <p><strong>Security:</strong> security@example.com</p>
        <p><strong>Export-Import:</strong> export@example.com</p>
        <p><strong>Warehouse:</strong> warehouse@example.com</p>
        <p><strong>Password:</strong> password</p>
    </div>
</div>
</div>
</div>
</div>
</body>

</html>
