<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Owner Dashboard</title>
  @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-gray-100">
  <div class="max-w-4xl mx-auto py-10">
    <h1 class="text-3xl font-bold mb-6">Owner Dashboard</h1>
    <p class="mb-4">Halo Owner, {{ auth()->user()->name }}!</p>

    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">Logout</button>
    </form>
  </div>
</body>
</html>
