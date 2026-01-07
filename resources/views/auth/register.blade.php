<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - PT. XYZ Approval System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-blue-900 to-blue-700">
    <div class="min-h-screen flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-lg shadow-2xl p-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-blue-900">PT. XYZ</h1>
                    <p class="text-gray-600 text-sm mt-1">Daftar Akun Baru</p>
                </div>

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form -->
                <form action="{{ route('register') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600 @error('name') border-red-500 @enderror"
                            value="{{ old('name') }}" required>
                        @error('name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                        <input type="email" name="email"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600 @error('email') border-red-500 @enderror"
                            value="{{ old('email') }}" required>
                        @error('email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Peran</label>
                        <select name="role"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600 @error('role') border-red-500 @enderror"
                            required>
                            <option value="">Pilih Peran</option>
                            <option value="supplier">Pemasok</option>
                            <option value="security">Keamanan</option>
                            <option value="export_import">Ekspor-Impor</option>
                            <option value="warehouse">Gudang</option>
                        </select>
                        @error('role')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                        <input type="password" name="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600 @error('password') border-red-500 @enderror"
                            required>
                        @error('password')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600"
                            required>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition">
                        Daftar
                    </button>
                </form>

                <!-- Footer -->
                <div class="mt-6 text-center">
                    <p class="text-gray-600 text-sm">Sudah punya akun? <a href="{{ route('login') }}"
                            class="text-blue-600 hover:underline font-semibold">Masuk di sini</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
