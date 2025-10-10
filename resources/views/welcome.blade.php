<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Landing Page</title>
  @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-gray-100">

  <div class="max-w-4xl mx-auto py-10">
    <h1 class="text-3xl font-bold mb-6">Landing Page</h1>
    <p class="mb-4">Halo broku</p>

  
    <!-- Tombol Login -->
    <a href="{{ route('login') }}" .kk
       class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold px-6 py-2 rounded-full shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
        Login
    </a>
    <a href="{{ route('register') }}" 
       class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold px-6 py-2 rounded-full shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
        register
    </a>

  </div>
</body>
</html>

  

   