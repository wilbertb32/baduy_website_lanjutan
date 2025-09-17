<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Baduy</title>
    <link rel="shortcut icon" href="{{ asset('images/logobadui1.webp') }}" type="image/png" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[url('{{asset('images/suasana1.jpg')}}')]  bg-cover bg-center bg-no-repeat">
    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            
            @if (session('status'))
            <div class="bg-green-600/90 text-white p-4 rounded mb-4">
                {{ session('status') }}
            </div>
            @endif

            @if ($errors->any())
            <div class="bg-red-600/90 text-white p-4 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="bg-gray-900/80 backdrop-blur-sm p-8 rounded-lg shadow-2xl">
                <!-- Logo Section -->
                <div class="text-center mb-8">
                    <img src="{{ asset('images/logobadui1.webp') }}" alt="Baduy Logo" class="w-24 h-auto mx-auto mb-4">
                    <h1 class="text-yellow-400 text-xl font-bold">Reset Password</h1>
                    <p class="text-gray-300 text-sm mt-2">
                        Enter your email to receive a password reset link
                    </p>
                </div>

                <!-- Form Section -->
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="w-full px-4 py-3 rounded-md shadow-sm border-gray-700 bg-gray-800/70 text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            required autofocus>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-md text-lg font-semibold transition duration-200">
                        Send Reset Link
                    </button>
                    
                    <div class="mt-6 text-center">
                        <a href="{{ route('login') }}" class="text-yellow-400 hover:text-yellow-300">
                            Back to Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
