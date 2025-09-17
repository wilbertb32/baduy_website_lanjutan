<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Basic -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <!-- Site Metas -->
  <title>{{ $article->title }} - Baduy</title>
  <meta name="keywords" content="">
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- font tambahan -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Site Icons -->
  <link rel="shortcut icon" href="{{ asset('images/logobadui1.webp') }}" type="image/png" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-900">
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

      <!-- Search Bar (tengah) - Hanya pada layar medium ke atas -->
      <div class="hidden md:flex flex-1 mx-8">
        <form action="{{ url('/artikel') }}" method="GET" class="w-full max-w-xl" role="search">
          <div class="relative flex items-center w-full">
            <input id="search" type="search" name="search" placeholder="Cari artikel..." 
                   class="w-full py-2 pl-4 pr-10 text-sm bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-blue-500" required />
            <button type="submit" class="absolute right-0 top-0 mt-2 mr-3 text-gray-400 hover:text-white">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
              </svg>
            </button>
          </div>
        </form>
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
        <a href="{{ url('/artikel') }}" class="text-yellow-400 font-semibold" :class="{'block py-2': mobileMenuOpen}">Article</a>

        @auth
        <div class="relative" x-data="{ open: false }">
          <button
            @click="open = !open"
            class="flex items-center text-white hover:text-yellow-400 font-medium w-full"
            :class="mobileMenuOpen ? 'block py-2 text-left' : ''"
            aria-haspopup="true"
            :aria-expanded="open.toString()">
            @if(Auth::user()->profileImage())
              <img src="{{ route('image.show', Auth::user()->profileImage()->id) }}" 
                   alt="Profile" class="w-8 h-8 rounded-full object-cover mr-2">
            @else
              <img src="{{ Auth::user()->defaultProfilePhotoUrl() }}" 
                   alt="Default" class="w-8 h-8 rounded-full object-cover mr-2">
            @endif
            <span>{{ Auth::user()->name }}</span>
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
            @if(Auth::user()->role === 'superadmin')
              <a href="{{ route('superadmin.dashboard') }}" class="block px-4 py-2 text-white hover:bg-gray-600">Super Admin Dashboard</a>
            @elseif(Auth::user()->role === 'admin')
              <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-white hover:bg-gray-600">Admin Dashboard</a>
            @endif
            <a href="{{ route('artikel.create') }}" class="block px-4 py-2 text-white hover:bg-gray-600">Tulis Artikel</a>
            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-white hover:bg-gray-600">Edit Profile</a>
            <div class="border-t border-gray-600"></div>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="block w-full text-left px-4 py-2 text-white hover:bg-gray-600">
                Logout
              </button>
            </form>
          </div>
        </div>
        @else
        <div class="flex items-center space-x-4" :class="{'flex-col space-y-2 space-x-0': mobileMenuOpen}">
          <a href="{{ route('login') }}" class="text-white hover:text-yellow-400 font-medium" :class="{'block py-2': mobileMenuOpen}">Login</a>
          <a href="{{ route('register') }}" class="bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-2 rounded-md transition-colors duration-300" :class="{'block w-full text-center': mobileMenuOpen}">Register</a>
        </div>
        @endauth
      </div>
    </div>
  </nav>
</header>

  <!-- Status Info untuk Pemilik Artikel (jika artikel pending/rejected) -->
  @if(Auth::check() && Auth::id() === $article->user_id && $article->status !== 'approved')
  <div class="bg-{{ $article->status === 'pending' ? 'yellow' : 'red' }}-500 text-white py-2 px-4 text-center">
    <span class="font-bold">
      @if($article->status === 'pending')
        ⏳ Artikel Anda sedang menunggu review dari admin
      @else
        ❌ Artikel Anda ditolak: {{ $article->rejection_reason ?? 'Tidak ada alasan yang diberikan' }}
      @endif
    </span>
  </div>
  @endif

  <!-- Main Content -->
  <main class="container mx-auto px-4 py-8 max-w-6xl relative">
    <!-- Back to Top Button -->
    <button id="back-to-top" class="fixed bottom-6 right-6 md:bottom-8 md:right-8 bg-gradient-to-r from-blue-600 to-blue-800 text-white p-3 rounded-full shadow-xl hover:shadow-2xl transition-all duration-300 opacity-0 invisible transform translate-y-4 z-40" aria-label="Back to top">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </button>

    <!-- Article Header -->
    <div class="bg-white rounded-xl shadow-2xl overflow-hidden mb-8 transform transition-all duration-500 hover:shadow-2xl hover:-translate-y-1">
        <!-- Header Image -->
        @if($article->headerImage())
        <div class="h-64 md:h-96 overflow-hidden relative">
            <img src="{{ route('image.show', $article->headerImage()->id) }}" 
                alt="{{ $article->title }}" 
                class="w-full h-full object-cover transition-transform duration-700 hover:scale-105">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
        </div>
        @endif

        <!-- Article Info -->
        <div class="p-6 md:p-8 relative">
            <!-- Floating category badge -->
            <div class="absolute -top-5 left-6">
                <span class="bg-gradient-to-r from-blue-600 to-blue-800 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                    {{ $article->genre }}
                </span>
            </div>
            
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                <div class="mt-4">
                    <h1 class="text-3xl md:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                        {{ $article->title }}
                    </h1>
                    <div class="flex flex-wrap items-center gap-4 text-gray-600">
                        <span class="flex items-center bg-gray-100 px-3 py-1 rounded-full">
                            <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            {{ $article->user->name }}
                        </span>
                        <span class="flex items-center bg-gray-100 px-3 py-1 rounded-full">
                            <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $article->created_at->format('d M Y, H:i') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Article Content -->
    <div class="bg-white rounded-xl shadow-xl p-6 md:p-8 mb-8">
        <div class="prose max-w-none text-justify break-words overflow-hidden text-gray-700">
            {!! $article->content !!}
        </div>
    </div>

    <!-- Gallery Images -->
    @if($article->galleryImages->count() > 0)
    <div class="bg-white rounded-xl shadow-xl p-6 md:p-8 mb-8">
        <h3 class="text-2xl font-bold mb-6 text-gray-800 border-b-2 border-blue-100 pb-2">📷 Galeri</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($article->galleryImages as $image)
            <div class="aspect-square overflow-hidden rounded-xl relative group">
                <img src="{{ route('image.show', $image->id) }}" 
                    alt="Gallery Image" 
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Back Button -->
    <div class="mt-8 text-center">
        <a href="{{ route('artikel') }}" 
            class="inline-flex items-center bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white px-8 py-4 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-1 font-semibold">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Daftar Artikel
        </a>
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
</body>
<script>
  // Back to Top Button Functionality
  document.addEventListener('DOMContentLoaded', function() {
      const backToTopButton = document.getElementById('back-to-top');
      
      window.addEventListener('scroll', function() {
          if (window.pageYOffset > 300) {
              backToTopButton.classList.remove('opacity-0', 'invisible', 'translate-y-4');
              backToTopButton.classList.add('opacity-100', 'visible', 'translate-y-0');
          } else {
              backToTopButton.classList.add('opacity-0', 'invisible', 'translate-y-4');
              backToTopButton.classList.remove('opacity-100', 'visible', 'translate-y-0');
          }
      });

      backToTopButton.addEventListener('click', function(e) {
          e.preventDefault();
          window.scrollTo({
              top: 0,
              behavior: 'smooth'
          });
      });
  });
</script>
</html>
