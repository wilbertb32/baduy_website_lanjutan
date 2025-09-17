<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Baduy Product</title>
  <link rel="shortcut icon" href="{{ asset('images/logobadui1.webp') }}" type="image/png" />
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex flex-col min-h-screen bg-gray-900 text-white">
  <header
    x-data="{ scrolled: false, mobileMenuOpen: false }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.pageYOffset > 20 })"
    :class="scrolled
    ? 'bg-gray-800 bg-opacity-90 backdrop-blur-md shadow-md'
    : 'bg-gray-800 bg-opacity-70 backdrop-blur-md'"
    class="sticky top-0 z-50 transition-colors duration-300 py-2">
    <nav class="container mx-auto px-4">
      <div class="flex items-center justify-between">
        <!-- Logo -->
        <div class="flex-shrink-0">
          <a href="{{ url('/') }}" class="flex items-center">
            <img src="{{ asset('images/logobadui1.webp') }}" class="h-12 w-auto object-contain" alt="Baduy Logo">
          </a>
        </div>

        <!-- Hamburger menu -->
        <div class="md:hidden">
          <button
            type="button"
            class="text-white hover:text-gray-300 focus:outline-none"
            @click="mobileMenuOpen = !mobileMenuOpen"
            aria-label="Toggle menu">
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
        </div>

        <!-- Nav links -->
        <div
          :class="mobileMenuOpen
          ? 'absolute top-16 right-4 bg-blue-900 bg-opacity-95 p-4 shadow-lg rounded-lg z-50 w-48 flex flex-col space-y-2'
          : 'hidden md:flex items-center space-x-6'"
          class="md:flex">
          <a href="{{ url('/') }}" class="text-white hover:text-yellow-400 font-medium" :class="{'block py-2': mobileMenuOpen}">Home</a>
          <a href="{{ url('/aboutUs') }}" class="text-white hover:text-yellow-400 font-medium" :class="{'block py-2': mobileMenuOpen}">About Us</a>
          <a href="{{ url('/marketplace') }}" class="text-white hover:text-yellow-400 font-medium" :class="{'block py-2': mobileMenuOpen}">Product</a>
          <a href="{{ url('/artikel') }}" class="text-white hover:text-yellow-400 font-medium" :class="{'block py-2': mobileMenuOpen}">Article</a>

          @auth
          <div class="relative" x-data="{ open: false }">
            <button
              @click="open = !open"
              class="flex items-center text-white hover:text-yellow-400 font-medium w-full"
              :class="mobileMenuOpen ? 'block py-2 text-left' : ''"
              aria-haspopup="true"
              :aria-expanded="open.toString()">
              <!-- UBAH: Profile Image BLOB -->
              @if(Auth::user()->profileImage())
                <img src="{{ route('image.show', Auth::user()->profileImage()->id) }}" alt="Profile Photo" class="w-8 h-8 rounded-full mr-2 object-cover">
              @else
                <img src="{{ Auth::user()->defaultProfilePhotoUrl() }}" alt="Profile Photo" class="w-8 h-8 rounded-full mr-2 object-cover">
              @endif
              {{ Auth::user()->name }}
              <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
              </svg>
            </button>

            <div
              x-show="open"
              @click.away="open = false"
              x-transition
              class="absolute right-0 mt-2 py-2 w-48 bg-gray-700 rounded-md shadow-lg z-10"
              style="display: none;">
              <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-white hover:bg-gray-600">
                Edit Profile
              </a>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-left px-4 py-2 text-white hover:bg-gray-600">
                  Logout
                </button>
              </form>
            </div>
          </div>
          @else
          <a href="{{ route('login') }}" class="text-white hover:text-yellow-400 font-medium" :class="{'block py-2': mobileMenuOpen}">Login</a>
          @endauth
        </div>
      </div>
    </nav>
  </header>

  <main class="flex-grow">
    <div class="container mx-auto">
      <section class="text-center py-12 bg-gray-800">
        <h1 class="text-4xl font-bold text-orange-400">Produk Suku Baduy</h1>
        <p class="text-gray-300 mt-2">Produk khas Suku Baduy yang dibuat secara tradisional dengan bahan alami.</p>
      </section>

      <!-- Grid produk dinamis -->
      <section class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
        @forelse($products as $product)
        <div class="bg-gray-700 p-4 rounded-lg shadow-lg">
          <!-- UBAH: Product Image BLOB -->
          @if($product->mainImage())
            <img src="{{ route('image.show', $product->mainImage()->id) }}" alt="{{ $product->name }}" class="rounded-lg w-full h-40 object-cover">
          @else
            <div class="rounded-lg w-full h-40 bg-gray-600 flex items-center justify-center">
              <span class="text-gray-400">No Image</span>
            </div>
          @endif
          <h2 class="text-lg font-semibold mt-4">{{ $product->name }}</h2>
          <p class="text-gray-300">{{ Str::limit($product->description, 100) }}</p>
          <div class="mt-4 flex justify-between items-center">
            <span class="text-yellow-400 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
            <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">Detail</a>
          </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-8">
          <p>Belum ada produk tersedia.</p>
        </div>
        @endforelse
      </section>
    </div>
  </main>

  <footer class="bg-[#262828] text-white py-8 mt-16">
    <div class="max-w-6xl mx-auto px-4">
      <div class="flex flex-col md:flex-row justify-between items-center space-y-6 md:space-y-0">

        <!-- Left: Logo / Title -->
        <div class="flex items-center space-x-4 text-center md:text-left">
          <img src="{{ asset('images/logobadui1.webp') }}" alt="Baduy Logo" class="me-10 w-10 h-10 object-contain">
          <div class="text-center md:text-left">
            <h2 class="text-sm font-bold text-yellow-400">Suku Baduy</h2>
            <p class="text-xs mt-1 text-gray-300">Preserving Culture. Promoting Tradition.</p>
          </div>
        </div>

        <!-- Center: Navigation -->
        <div class="space-x-4 text-sm">
          <a href="{{ url('/') }}" class="hover:text-yellow-400 transition">Home</a>
          <a href="{{ url('/aboutUs') }}" class="hover:text-yellow-400 transition">About</a>
          <a href="{{ url('/marketplace') }}" class="hover:text-yellow-400 transition">Products</a>
          <a href="{{ url('/artikel') }}" class="hover:text-yellow-400 transition">Article</a>
        </div>

        <!-- Right: Social Media -->
        <div class="flex space-x-4">
          <a href="#" class="hover:text-yellow-400 transition">
            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
              <path d="M22 4.01c-.77.34-1.6.56-2.46.66a4.26 4.26 0 0 0 1.88-2.36c-.83.49-1.74.85-2.7 1.04a4.24 4.24 0 0 0-7.22 3.87 12.01 12.01 0 0 1-8.73-4.43 4.25 4.25 0 0 0 1.31 5.67 4.21 4.21 0 0 1-1.92-.53v.05a4.25 4.25 0 0 0 3.4 4.17 4.28 4.28 0 0 1-1.91.07 4.25 4.25 0 0 0 3.97 2.95 8.5 8.5 0 0 1-5.28 1.82c-.34 0-.68-.02-1.01-.06a12.03 12.03 0 0 0 6.5 1.91c7.8 0 12.07-6.46 12.07-12.07 0-.18 0-.35-.01-.53A8.65 8.65 0 0 0 22 4.01z" />
            </svg>
          </a>
          <a href="#" class="hover:text-yellow-400 transition">
            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
              <path d="M12 2.04c-5.52 0-10 4.47-10 9.98 0 4.41 3.59 8.08 8.27 8.98v-6.36H7.9v-2.62h2.37V9.57c0-2.35 1.38-3.65 3.5-3.65 1.02 0 2.1.18 2.1.18v2.3h-1.18c-1.16 0-1.52.72-1.52 1.45v1.74h2.59l-.41 2.62h-2.18v6.36C18.41 20.1 22 16.43 22 11.98c0-5.5-4.48-9.97-10-9.97z" />
            </svg>
          </a>
        </div>
      </div>

      <div class="border-t border-gray-700 mt-8 pt-4 text-center text-sm text-gray-400">
        © Baduy Official. All rights reserved.
      </div>
    </div>
  </footer>

  <!-- JS FILES -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const button = document.getElementById('mobile-menu-button');
      const menu = document.getElementById('navbar-menu');

      button.addEventListener('click', function() {
        menu.classList.toggle('hidden');
        menu.classList.toggle('flex');
        menu.classList.toggle('flex-col');
        menu.classList.toggle('absolute');
        menu.classList.toggle('top-16');
        menu.classList.toggle('left-0');
        menu.classList.toggle('w-full');
        menu.classList.toggle('text-left');
        menu.classList.toggle('bg-gray-800');
        menu.classList.toggle('p-4');
        menu.classList.toggle('rounded');
        menu.classList.toggle('shadow-lg');
        menu.classList.toggle('z-10');

        // Styling untuk item menu
        const menuItems = menu.querySelectorAll('a');
        menuItems.forEach(item => {
          item.classList.toggle('block');
          item.classList.toggle('mb-2');
          item.classList.toggle('pl-2');
        });
      });
    });
  </script>
</body>

</html>