<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    @vite('resources/css/app.css') {{-- aktif kalau pakai Tailwind --}}
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">

    <div class="bg-white p-6 rounded-xl shadow-md w-96">
        <h1 class="text-2xl font-bold mb-4">Register</h1>

        @if(session('success'))
            <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="block font-medium">Nama</label>
                <input type="text" name="name" class="w-full border rounded p-2" value="{{ old('name') }}">
                @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-3">
                <label class="block font-medium">Email</label>
                <input type="email" name="email" class="w-full border rounded p-2" value="{{ old('email') }}">
                @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-3">
                <label class="block font-medium">Password</label>
                <input type="password" name="password" class="w-full border rounded p-2">
                @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-3">
                <label class="block font-medium">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full border rounded p-2">
            </div>

            <button type="submit" class="bg-blue-600 text-white w-full p-2 rounded hover:bg-blue-700">
                Register
            </button>
        </form>
    </div>

</body>
</html>
