<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">

    
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    
    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-8 border border-gray-200">
        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 text-green-600 text-center">
                {{ session('status') }}
            </div>
        @endif

        <h2 class="text-center text-3xl font-semibold text-gray-800 mb-6 tracking-wide" style="font-family: 'Poppins', sans-serif;">
            Login 
        </h2>
        
        
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-gray-600 text-sm">Email</label>
                <input id="email" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-400 focus:border-gray-400 p-2" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                @error('email')
                    <p class="mt-2 text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-gray-600 text-sm">Password</label>
                <input id="password" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-400 focus:border-gray-400 p-2" type="password" name="password" required autocomplete="current-password">
                @error('password')
                    <p class="mt-2 text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center text-gray-600 text-sm">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-gray-600 shadow-sm focus:ring-gray-400" name="remember">
                    <span class="ms-2">Remember me</span>
                </label>
                @if (Route::has('password.request'))
                    <a class="text-sm text-gray-600 hover:underline" href="{{ route('password.request') }}">
                        Forgot your password?
                    </a>
                @endif
            </div>

            <!-- Buttons -->
            <div class="mt-6">
                <button type="submit" class="w-full py-2 bg-gray-800 hover:bg-gray-900 transition text-white rounded-md">
                    Log in
                </button>
            </div>

            <!-- Login with Google -->
            <div class="mt-4 flex items-center justify-center">
                <a href="{{ route('google.login') }}" class="w-full flex items-center justify-center border border-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-100 transition">
                    <svg class="w-5 h-5 mr-2" viewBox="0 0 48 48">
                        <path fill="#4285F4" d="M44.5 20H24v8.5h11.9C33.1 32.1 30 35 26 36.3l6.1 4.5c5.5-3.6 8.8-9.4 8.8-16.3 0-1.1-.1-2.1-.3-3.2z"/>
                        <path fill="#34A853" d="M24 44c6.4 0 11.7-2.1 15.6-5.8l-6.1-4.5c-2.1 1.4-4.8 2.2-7.7 2.2-5.9 0-10.8-4-12.5-9.4l-6.2 4.8C11 38.2 17 44 24 44z"/>
                        <path fill="#FBBC05" d="M11.5 26.5c-.5-1.6-.8-3.3-.8-5s.3-3.4.8-5l-6.2-4.8C3.6 14.1 3 17 3 21s.6 6.9 1.7 9.8l6.2-4.8z"/>
                        <path fill="#EA4335" d="M24 10.5c3.3 0 6.2 1.1 8.5 3.2l6.4-6.4C34.5 3.1 29.3 1 24 1 17 1 11 6 8 13l6.2 4.8c1.7-5.4 6.6-9.3 12.5-9.3z"/>
                    </svg>
                    Login dengan Google
                </a>
            </div>

            <!-- Register Link -->
            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Daftar di sini</a>
                </p>
            </div>

        </form>
    </div>

</body>
</html>
