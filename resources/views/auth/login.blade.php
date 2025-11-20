<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CuciCar</title>
    @vite('resources/css/app.css')
    <style>
        .bg-car-wash {
            background-image: url('{{ asset("images/car-wash-bg.jpg") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body class="bg-teal-200 bg-car-wash min-h-screen flex items-center justify-center p-4">
    
    <div class="w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden flex">
        
        <!-- Left Side - Form -->
        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center bg-gray-50">
            <h1 class="text-4xl font-bold text-gray-600 mb-10 text-center tracking-wider">LOGIN</h1>

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login.process') }}" method="POST" class="space-y-5">
                @csrf
                
                <!-- Email Field -->
                <div>
                    <input 
                        type="email" 
                        name="email" 
                        placeholder="Email" 
                        value="{{ old('email') }}"
                        required
                        class="w-full px-5 py-3 border-2 border-gray-400 rounded-full focus:outline-none focus:border-gray-600 transition text-gray-700"
                    >
                </div>

                <!-- Password Field -->
                <div class="relative">
                    <input 
                        type="password" 
                        name="password" 
                        id="password"
                        placeholder="Password" 
                        required
                        class="w-full px-5 py-3 border-2 border-gray-400 rounded-full focus:outline-none focus:border-gray-600 transition text-gray-700"
                    >
                    <button 
                        type="button" 
                        onclick="togglePassword('password')"
                        class="absolute right-5 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                </div>

                <!-- Login Button -->
                <div class="pt-2">
                    <button 
                        type="submit" 
                        class="w-full bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 rounded-full transition duration-200 shadow-md"
                    >
                        Login
                    </button>
                </div>

                <!-- Divider -->
                <div class="flex items-center my-6">
                    <div class="flex-1 border-t border-gray-400"></div>
                    <span class="px-4 text-gray-500 font-medium">or</span>
                    <div class="flex-1 border-t border-gray-400"></div>
                </div>

                <!-- Social Login Buttons -->
                <div class="flex justify-center space-x-8">
                    <button 
                        type="button" 
                        class="flex items-center justify-center hover:opacity-80 transition"
                    >
                        <svg class="w-10 h-10" viewBox="0 0 48 48">
                            <path fill="#4285F4" d="M45.12 24.5c0-1.56-.14-3.06-.4-4.5H24v8.51h11.84c-.51 2.75-2.06 5.08-4.39 6.64v5.52h7.11c4.16-3.83 6.56-9.47 6.56-16.17z"/>
                            <path fill="#34A853" d="M24 46c5.94 0 10.92-1.97 14.56-5.33l-7.11-5.52c-1.97 1.32-4.49 2.1-7.45 2.1-5.73 0-10.58-3.87-12.31-9.07H4.34v5.7C7.96 41.07 15.4 46 24 46z"/>
                            <path fill="#FBBC05" d="M11.69 28.18C11.25 26.86 11 25.45 11 24s.25-2.86.69-4.18v-5.7H4.34C2.85 17.09 2 20.45 2 24c0 3.55.85 6.91 2.34 9.88l7.35-5.7z"/>
                            <path fill="#EA4335" d="M24 10.75c3.23 0 6.13 1.11 8.41 3.29l6.31-6.31C34.91 4.18 29.93 2 24 2 15.4 2 7.96 6.93 4.34 14.12l7.35 5.7c1.73-5.2 6.58-9.07 12.31-9.07z"/>
                        </svg>
                    </button>
                    <button 
                        type="button" 
                        class="flex items-center justify-center hover:opacity-80 transition"
                    >
                        <svg class="w-10 h-10" viewBox="0 0 48 48">
                            <path fill="#1877F2" d="M24 4C12.95 4 4 12.95 4 24c0 10.02 7.37 18.31 17 19.77V30h-5v-6h5v-4.5c0-4.95 2.94-7.69 7.47-7.69 2.16 0 4.43.39 4.43.39v4.86h-2.5c-2.46 0-3.23 1.53-3.23 3.1V24h5.5l-.88 6H27.4v13.77c9.63-1.46 17-9.75 17-19.77 0-11.05-8.95-20-20-20z"/>
                        </svg>
                    </button>
                </div>

                <!-- Register Link -->
                <p class="text-center text-gray-600 mt-4">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                        Register here
                    </a>
                </p>
            </form>
        </div>

        <!-- Right Side - Logo with vertical teal bar -->
        <div class="hidden md:flex w-1/2 bg-white items-center justify-center relative">
            <!-- Vertical Teal Bar -->
            <div class="absolute left-0 top-0 h-full w-12 bg-teal-500"></div>
            
            <!-- Logo Area -->
            <div class="text-center pl-12">
                <div class="text-5xl font-bold">
                    <span class="text-blue-900">cuci</span><span class="text-teal-500">car</span>
                </div>
                <div class="w-32 h-1 bg-blue-900 mx-auto mt-2"></div>
            </div>
        </div>

    </div>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            if (input.type === 'password') {
                input.type = 'text';
            } else {
                input.type = 'password';
            }
        }
    </script>

</body>
</html>