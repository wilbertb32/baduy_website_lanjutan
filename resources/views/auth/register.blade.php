<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Baduy</title>
    <link rel="shortcut icon" href="{{ asset('images/logobadui1.webp') }}" type="image/png" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[url('{{asset('images/lumbungpadi2.jpg')}}')]  bg-cover bg-center bg-no-repeat">
    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-4xl">

            @if (session('success'))
            <div class="bg-green-600/90 text-white p-4 rounded mb-4">
                {{ session('success') }}
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

            <div class="bg-gray-900/80 backdrop-blur-sm p-8 rounded-lg shadow-2xl flex flex-col md:flex-row">
                <!-- Logo Section -->
                <div class="md:w-1/3 flex flex-col items-center justify-center mb-8 md:mb-0 border-b md:border-b-0 md:border-r border-gray-700 pb-8 md:pb-0 md:pr-8">
                    <img src="{{ asset('images/logobadui1.webp') }}" alt="Baduy Logo" class="w-40 h-auto mb-6">
                    <h1 class="text-yellow-400 text-2xl font-bold text-center">Suku Baduy</h1>
                    <p class="text-gray-300 text-center mt-2">Preserving Culture. Promoting Tradition.</p>
                </div>

                <!-- Form Section -->
                <div class="md:w-2/3 md:pl-8">
                    <h2 class="text-center text-3xl font-bold mb-6 text-yellow-400">Register</h2>
                    <form method="POST" action="{{ route('register.store') }}">
                        @csrf
                        <div class="mb-5">
                            <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Name</label>
                            <input type="text" name="name" id="name"
                                class="w-full px-4 py-3 rounded-md shadow-sm border-gray-700 bg-gray-800/70 text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                required>
                        </div>
                        <div class="mb-5">
                            <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                            <input type="email" name="email" id="email"
                                class="w-full px-4 py-3 rounded-md shadow-sm border-gray-700 bg-gray-800/70 text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                required>
                        </div>

                        <!-- Password Field with Toggle Button -->
                        <div class="mb-5 relative" x-data="{ showPassword: false }">
                            <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                            <div class="relative">
                                <input
                                    :type="showPassword ? 'text' : 'password'"
                                    name="password"
                                    id="password"
                                    class="w-full px-4 py-3 pr-10 rounded-md shadow-sm border-gray-700 bg-gray-800/70 text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                    required>
                                <button
                                    type="button"
                                    @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-200 focus:outline-none"
                                    tabindex="-1">
                                    <!-- Eye icon (shown when password is hidden) -->
                                    <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                    <!-- Crossed eye icon (shown when password is visible) -->
                                    <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Confirm Password Field with Toggle Button -->
                        <div class="mb-6 relative" x-data="{ showConfirmPassword: false }">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">Confirm Password</label>
                            <div class="relative">
                                <input
                                    :type="showConfirmPassword ? 'text' : 'password'"
                                    name="password_confirmation"
                                    id="password_confirmation"
                                    class="w-full px-4 py-3 pr-10 rounded-md shadow-sm border-gray-700 bg-gray-800/70 text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                    required>
                                <button
                                    type="button"
                                    @click="showConfirmPassword = !showConfirmPassword"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-200 focus:outline-none"
                                    tabindex="-1">
                                    <!-- Eye icon (shown when password is hidden) -->
                                    <svg x-show="!showConfirmPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                    <!-- Crossed eye icon (shown when password is visible) -->
                                    <svg x-show="showConfirmPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-md text-lg font-semibold transition duration-200">
                            Register
                        </button>
                        <div class="mt-6 text-center">
                            <a href="{{ route('login') }}" class="text-yellow-400 hover:text-yellow-300">
                                Already have an account? Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-8  text-center">
                <a href="{{ url('/') }}" class="inline-flex items-center text-gray-300 hover:text-yellow-400 bg-gray-900/40 py-2 px-4 rounded-full backdrop-blur-sm transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</body>

</html>