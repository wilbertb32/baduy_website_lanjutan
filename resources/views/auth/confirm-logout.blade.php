<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Logout - Baduy</title>
    <link rel="shortcut icon" href="{{ asset('images/logobadui1.webp') }}" type="image/png" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[url('{{asset('images/suasana1.jpg')}}')] bg-cover bg-center bg-no-repeat">
    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <div class="bg-gray-900/90 backdrop-blur-sm p-8 rounded-lg shadow-2xl">
                <!-- Logo Section -->
                <div class="text-center mb-8">
                    <img src="{{ asset('images/logobadui1.webp') }}" alt="Baduy Logo" class="w-24 h-auto mx-auto mb-4">
                    <h1 class="text-yellow-400 text-xl font-bold">Suku Baduy</h1>
                </div>

                <!-- Alert Section -->
                <div class="text-center mb-6">
                    <div class="bg-yellow-600/20 border border-yellow-600/50 rounded-lg p-4 mb-4">
                        <svg class="w-12 h-12 text-yellow-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <h3 class="text-white text-lg font-semibold mb-2">You are already logged in!</h3>
                        <p class="text-gray-300 text-sm">
                            You are currently logged in as <strong class="text-yellow-400">{{ Auth::user()->name }}</strong>. 
                            To access the {{ $intendedRoute }} page, you need to logout first.
                        </p>
                    </div>
                    
                    <p class="text-gray-300 text-sm mb-6">
                        Do you want to logout and continue to the {{ $intendedRoute }} page?
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-3">
                    <form method="POST" action="{{ route('auth.confirm-logout.submit') }}">
                        @csrf
                        <input type="hidden" name="intended" value="{{ $intendedRoute }}">
                        <button type="submit" 
                            class="w-full bg-red-600 hover:bg-red-700 text-white py-3 rounded-md text-sm font-semibold transition duration-200 shadow-lg hover:shadow-xl">
                            Yes, Logout and Continue
                        </button>
                    </form>
                    
                    <!-- Pastikan route ini benar -->
                    <form method="POST" action="{{ route('auth.confirm-logout.cancel') }}">
                        @csrf
                        <input type="hidden" name="previous_url" value="{{ $previousUrl ?? '' }}">
                        <button type="submit" 
                            class="w-full bg-gray-600 hover:bg-gray-700 text-white py-3 rounded-md text-sm font-semibold transition duration-200">
                            Cancel, Stay Logged In
                        </button>
                    </form>
                </div>

                <!-- User Role Info -->
                <div class="mt-6 text-center">
                    <p class="text-gray-400 text-xs">
                        Logged in as {{ ucfirst(Auth::user()->role) }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>