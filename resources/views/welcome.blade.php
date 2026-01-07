<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aplikasi Persetujuan PT. XYZ</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="w-full max-w-lg">
            <!-- Welcome Card -->
            <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">
                        Aplikasi Persetujuan
                    </h1>
                    <p class="text-xl text-gray-600">PT. XYZ</p>
                </div>

                <div class="bg-blue-50 rounded-lg p-4 mb-6">
                    <p class="text-gray-700 text-sm mb-3">
                        <strong>Selamat datang!</strong> Sistem manajemen persetujuan dokumen untuk PT. XYZ dengan 4
                        level persetujuan.
                    </p>
                </div>

                <!-- Features -->
                <div class="grid grid-cols-2 gap-4 mb-6 text-left">
                    <div class="bg-green-50 p-3 rounded">
                        <p class="font-semibold text-green-700">📦 Supplier</p>
                        <p class="text-xs text-gray-600">Buat form persetujuan</p>
                    </div>
                    <div class="bg-yellow-50 p-3 rounded">
                        <p class="font-semibold text-yellow-700">🛡️ Security</p>
                        <p class="text-xs text-gray-600">Verifikasi pertama</p>
                    </div>
                    <div class="bg-purple-50 p-3 rounded">
                        <p class="font-semibold text-purple-700">✈️ Export-Import</p>
                        <p class="text-xs text-gray-600">Verifikasi kedua</p>
                    </div>
                    <div class="bg-blue-50 p-3 rounded">
                        <p class="font-semibold text-blue-700">📋 Warehouse</p>
                        <p class="text-xs text-gray-600">Verifikasi final</p>
                    </div>
                </div>

                <!-- Demo Credentials -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left">
                    <p class="font-semibold text-gray-700 mb-2">📧 Demo Akun:</p>
                    <div class="text-xs text-gray-600 space-y-1">
                        <p><strong>Supplier:</strong> supplier@example.com / password</p>
                        <p><strong>Security:</strong> security@example.com / password</p>
                        <p><strong>Export-Import:</strong> export@example.com / password</p>
                        <p><strong>Warehouse:</strong> warehouse@example.com / password</p>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3">
                    <a href="{{ route('login') }}"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">
                        Login
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded transition">
                            Register
                        </a>
                    @endif
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">
                    © 2024 PT. XYZ Approval System. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>

</html>
