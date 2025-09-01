<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - CarWash</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded shadow">
        <h1 class="text-2xl font-bold mb-6 text-center">Login</h1>

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.process') }}">
            @csrf
            <div class="mb-4">
                <label class="block mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-3 py-2 border rounded">
            </div>
            <div class="mb-4">
                <label class="block mb-1">Password</label>
                <input type="password" name="password" required
                       class="w-full px-3 py-2 border rounded">
            </div>
            <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                Login
            </button>
        </form>
    </div>
</body>
</html>
