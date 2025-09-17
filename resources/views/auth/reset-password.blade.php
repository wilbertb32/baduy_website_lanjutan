<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Baduy</title>
    <link rel="shortcut icon" href="{{ asset('images/logobadui1.webp') }}" type="image/png" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[url('{{asset('images/suasana1.jpg')}}')]  bg-cover bg-center bg-no-repeat">
    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            
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
                        Enter your new password
                    </p>
                </div>

                <!-- Form Section -->
                <form method="POST" action="{{ route('password.store') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="mb-5">
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $request->email) }}"
                            class="w-full px-4 py-3 rounded-md shadow-sm border-gray-700 bg-gray-800/70 text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            required>
                    </div>

                    <div class="mb-5" x-data="{ showPassword: false }">
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
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-200 focus:outline-none">
                                <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="mb-6" x-data="{ showConfirmPassword: false }">
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
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-200 focus:outline-none">
                                <svg x-show="!showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg x-show="showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-md text-lg font-semibold transition duration-200">
                        Reset Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
