<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Basic -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <!-- Site Metas -->
  <title>Artikel Page Baduy</title>
  <meta name="keywords" content="">
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- font tambahan -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Site Icons -->
  <link rel="shortcut icon" href="{{ asset('images/logobadui1.webp') }}" type="image/png" />
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-gray-900">
  <header
    x-data="{ scrolled: false, mobileMenuOpen: false, mobileSearchOpen: false }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.pageYOffset > 0 })"
    :class="scrolled
      ? 'bg-gray-800 bg-opacity-90 backdrop-blur-md shadow-md'
      : 'bg-gray-800 bg-opacity-70 backdrop-blur-md'"
    class="sticky top-0 z-50 transition-colors duration-300">
    
    <nav class="container mx-auto px-4 py-2">
      <div class="flex items-center justify-between">
        <!-- Logo -->
        <div class="flex-shrink-0">
          <a href="{{ url('/') }}" class="flex items-center">
            <img src="{{ asset('images/logobadui1.webp') }}" class="h-12 w-auto object-contain" alt="Baduy Logo">
          </a>
        </div>

        <!-- Search Bar (Desktop) -->
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

        <!-- Nav Links (Desktop) -->
        <div class="hidden md:flex items-center space-x-6">
          <a href="{{ url('/') }}" class="text-white hover:text-yellow-400 font-medium">Home</a>
          <a href="{{ url('/aboutUs') }}" class="text-white hover:text-yellow-400 font-medium">About Us</a>
          <a href="{{ url('/marketplace') }}" class="text-white hover:text-yellow-400 font-medium">Product</a>
          <a href="{{ url('/artikel') }}" class="text-yellow-400 font-semibold">Article</a>

          @auth
          <div class="relative" x-data="{ open: false }">
            <button
              @click="open = !open"
              class="flex items-center text-white hover:text-yellow-400 font-medium"
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
          <div class="flex items-center space-x-4">
            <a href="{{ route('login') }}" class="text-white hover:text-yellow-400 font-medium">Login</a>
            <a href="{{ route('register') }}" class="bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-2 rounded-md transition-colors duration-300">Register</a>
          </div>
          @endauth
        </div>

        <!-- Mobile Menu Button -->
        <div class="md:hidden flex items-center space-x-4">
          <!-- Search Icon Mobile -->
          <button
            type="button"
            class="text-white hover:text-gray-300 focus:outline-none"
            @click="mobileSearchOpen = !mobileSearchOpen; mobileMenuOpen = false"
            aria-label="Toggle search">
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </button>

          <!-- Hamburger Menu -->
          <button
            type="button"
            class="text-white hover:text-gray-300 focus:outline-none"
            @click="mobileMenuOpen = !mobileMenuOpen; mobileSearchOpen = false"
            aria-label="Toggle menu">
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
        </div>
      </div>

      <!-- Mobile Search Bar -->
      <div x-show="mobileSearchOpen" 
           x-transition:enter="transition ease-out duration-200"
           x-transition:enter-start="opacity-0 -translate-y-2"
           x-transition:enter-end="opacity-100 translate-y-0"
           x-transition:leave="transition ease-in duration-150"
           x-transition:leave-start="opacity-100 translate-y-0"
           x-transition:leave-end="opacity-0 -translate-y-2"
           class="mt-2 md:hidden">
        <form action="{{ url('/artikel') }}" method="GET" class="w-full" role="search">
          <div class="relative flex items-center w-full">
            <input id="mobile-search" type="search" name="search" placeholder="Cari artikel..." 
                  class="w-full py-2 pl-4 pr-10 text-sm bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-blue-500" required />
            <button type="submit" class="absolute right-0 top-0 mt-2 mr-3 text-gray-400 hover:text-white">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
              </svg>
            </button>
          </div>
        </form>
      </div>

      <!-- Mobile Menu -->
      <div
        :class="mobileMenuOpen
          ? 'md:hidden absolute top-16 right-4 bg-blue-900 bg-opacity-95 p-4 shadow-lg rounded-lg z-50 w-48 flex flex-col space-y-2'
          : 'hidden'">
        <a href="{{ url('/') }}" class="text-white hover:text-yellow-400 font-medium block py-2">Home</a>
        <a href="{{ url('/aboutUs') }}" class="text-white hover:text-yellow-400 font-medium block py-2">About Us</a>
        <a href="{{ url('/marketplace') }}" class="text-white hover:text-yellow-400 font-medium block py-2">Product</a>
        <a href="{{ url('/artikel') }}" class="text-yellow-400 font-semibold block py-2">Article</a>

        @auth
        <div class="relative" x-data="{ open: false }">
          <button
            @click="open = !open"
            class="flex items-center text-white hover:text-yellow-400 font-medium w-full py-2 text-left"
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
        <div class="flex flex-col space-y-2">
          <a href="{{ route('login') }}" class="text-white hover:text-yellow-400 font-medium block py-2">Login</a>
          <a href="{{ route('register') }}" class="bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-2 rounded-md transition-colors duration-300 block w-full text-center">Register</a>
        </div>
        @endauth
      </div>
    </nav>
  </header>

  <main class="flex-grow"> <!-- mt-16 untuk memberi ruang header fixed -->
    <!-- Banner Area -->
    <div class="relative overflow-hidden h-[400px] md:h-[500px] lg:h-[600px] pt-16">
        <!-- Background with overlay and parallax effect -->
        <div class="absolute inset-0 z-0">
          <div 
            class="w-full h-full bg-cover bg-center bg-no-repeat scale-100 hover:scale-105 transition-transform duration-700"
            style="background-image: url('{{ asset('images/banner-artikel.jpg') }}')"
          ></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#305792]/90 to-[#313a4d]/70"></div>
        </div>

        <!-- Content Container -->
        <div class="container mx-auto px-4 h-full flex items-center justify-center relative z-10">
            <div class="max-w-3xl text-center">
                <!-- Main Title -->
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 opacity-0 animate-[fadeInUp_0.8s_ease-out_0.1s_forwards]">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-yellow-300 to-yellow-400">
                        Welcome To Article
                    </span>
                </h2>
                
                <!-- Quote Section -->
                <div class="relative">
                    <!-- Decorative Quote Icon -->
                    <svg class="w-10 h-10 mx-auto text-white/30 mb-4 opacity-0 animate-[fadeInUp_0.8s_ease-out_0.2s_forwards]" 
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    
                    <!-- Quote Text -->
                    <blockquote class="text-lg md:text-xl text-yellow-100 italic font-serif leading-relaxed mb-6 opacity-0 animate-[fadeInUp_0.8s_ease-out_0.3s_forwards]">
                        "Tak perlu listrik untuk menyinari kehidupan. Baduy mengajarkan bahwa cahaya sejati berasal dari kesederhanaan dan keharmonisan."
                    </blockquote>
                    
                    <!-- Decorative Line -->
                    <div class="w-24 h-1 bg-gradient-to-r from-[#f9f9e1] to-[#f3f3c3] mx-auto rounded-full opacity-0 animate-[fadeInUp_0.8s_ease-out_0.4s_forwards]"></div>
                </div>
                
                <!-- Scroll Indicator -->
                <div class="mt-12 opacity-0 animate-[fadeInUp_0.8s_ease-out_0.5s_forwards,bounce_2s_infinite_1s]">
                    <svg class="w-8 h-8 mx-auto text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </div>
            </div>
        </div>
      </div>

        <!-- Section Kategori Horizontal -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 py-1 shadow-md">
          <div class="container mx-auto px-4">
              <div class="relative flex justify-center">
                  <ul class="flex space-x-4 md:space-x-6 overflow-x-auto py-3 scrollbar-hide mx-auto">
                      @php
                          $categories = [
                              'all' => 'Terbaru',
                              'Budaya & Tradisi' => 'Budaya & Tradisi',
                              'Kearifan Lokal' => 'Kearifan Lokal', 
                              'Mitos & Kepercayaan' => 'Mitos & Kepercayaan',
                              'Lokasi' => 'Lokasi'
                          ];
                      @endphp
                      
                      @foreach($categories as $key => $label)
                      <li class="flex-shrink-0">
                          @if($key === 'all')
                              <a href="{{ url('/artikel') }}" 
                                  class="relative block px-5 py-2.5 rounded-lg transition-all duration-300 group
                                      @if(!request('genre')) 
                                          bg-white text-blue-800 font-semibold shadow-lg
                                      @else 
                                          bg-white/20 text-white hover:bg-white/30
                                      @endif">
                          @else
                              <a href="{{ route('artikel', ['genre' => $key]) }}" 
                                  class="relative block px-5 py-2.5 rounded-lg transition-all duration-300 group
                                      @if(request('genre') == $key) 
                                          bg-white text-blue-800 font-semibold shadow-lg
                                      @else 
                                          bg-white/20 text-white hover:bg-white/30
                                      @endif">
                          @endif
                                  <span class="relative z-10 whitespace-nowrap">
                                      {{ $label }}
                                  </span>
                                  
                                  <!-- Active indicator -->
                                  @if(($key === 'all' && !request('genre')) || request('genre') == $key)
                                  <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-6 h-1 bg-yellow-300 rounded-t-md"></span>
                                  @endif
                              </a>
                      </li>
                      @endforeach
                  </ul>
              </div>
          </div>
        </div>

        <!-- section artikel -->
        <div id="article-section" class="py-16 bg-gray-900">
          <div class="container mx-auto px-4">
              <div class="flex flex-col lg:flex-row">
                  <!-- Main Content Area -->
                  <div class="w-full lg:w-8/12 lg:pr-8 overflow-x-hidden">
                      <!-- Search Alerts -->
                      @if(request()->has('search'))
                          @if($articles->isEmpty())
                              <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-800 p-4 mb-8 rounded-r-lg shadow-sm">
                                  <p class="font-medium">Tidak ditemukan hasil untuk: <strong class="text-yellow-900">{{ request('search') }}</strong></p>
                              </div>
                          @else
                              <div class="bg-green-50 border-l-4 border-green-400 text-green-800 p-4 mb-8 rounded-r-lg shadow-sm">
                                  <p class="font-medium">Menampilkan hasil untuk: <strong class="text-green-900">{{ request('search') }}</strong></p>
                              </div>
                          @endif
                      @endif

                      <!-- Success Message -->
                      @if(session('success'))
                      <div class="bg-green-50 border-l-4 border-green-400 text-green-800 p-4 mb-8 rounded-r-lg shadow-sm flex justify-between items-center">
                          <span class="font-medium">{{ session('success') }}</span>
                          <button type="button" class="text-green-600 hover:text-green-900 transition-colors" data-dismiss="alert" aria-label="Close">
                              <span class="text-2xl leading-none">&times;</span>
                          </button>
                      </div>
                      @endif

                      <!-- Articles List -->
                      <div class="space-y-12">
                        @foreach ($articles as $article)
                        <article class="group relative flex flex-col md:flex-row gap-6 pb-12 border-b border-gray-700 hover:border-yellow-400 transition-colors duration-300">
                            <!-- Author Avatar -->
                            <div class="flex-shrink-0 relative">
                              <div class="absolute -inset-2 bg-blue-900/30 rounded-2xl transform scale-95 opacity-0 group-hover:scale-100 group-hover:opacity-100 transition-all duration-300 z-0"></div>
                              <img 
                                  src="{{ $article->user->profile_photo_url }}" 
                                  alt="{{ $article->user->name }}" 
                                  class="relative z-10 w-20 h-20 md:w-24 md:h-24 rounded-full object-cover border-2 border-gray-600 shadow-md hover:scale-110 hover:border-yellow-400 hover:shadow-lg transition-all duration-200 ease-out">
                            </div>
                             <!-- Article Content -->
                              <div class="flex-1 min-w-0">
                                <div class="flex items-center mb-2">
                                    <h3 class="text-xl font-semibold text-yellow-400 hover:text-yellow-300 transition-colors">
                                        {{ $article->user->name }}
                                    </h3>
                                    <span class="mx-2 text-gray-400">•</span>
                                    <time class="text-sm text-gray-300">
                                        @if($article->created_at)
                                            {{ $article->created_at->format('F j, Y') }}
                                        @else
                                            Tanggal tidak tersedia
                                        @endif
                                    </time>
                                </div>

                                <h2 class="text-2xl md:text-3xl font-bold mb-3 text-white group-hover:text-yellow-300 transition-colors">
                                    <a href="{{ route('artikel.show', $article->id) }}" class="hover:underline decoration-yellow-400 underline-offset-4">
                                        {{ $article->title }}
                                    </a>
                                </h2>

                                <p class="text-lg text-gray-300 mb-4 leading-relaxed text-justify hyphens-auto tracking-wide">
                                    {!! Str::limit(
                                        html_entity_decode(
                                            strip_tags(
                                                str_replace(['&nbsp;', '<br>', '<br/>'], ' ', $article->content)
                                            ), 
                                        ENT_QUOTES, 'UTF-8'), 
                                    400) !!}
                                </p>

                                <a href="{{ route('artikel.show', $article->id) }}" class="inline-flex items-center text-yellow-400 hover:text-yellow-300 font-medium transition-colors">
                                    Baca lebih banyak
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        </article>
                        @endforeach
                    </div>

                      <!-- paginasi -->
                      @if($articles->hasPages())
                      <div class="mt-16">
                          <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                              <!-- Info halaman -->
                              <div class="text-base text-gray-300">
                                  Menampilkan <span class="font-semibold text-yellow-300">{{ $articles->firstItem() }}</span> - 
                                  <span class="font-semibold text-yellow-300">{{ $articles->lastItem() }}</span> dari 
                                  <span class="font-semibold text-yellow-300">{{ $articles->total() }}</span> artikel
                              </div>
                              
                              <!-- Navigasi halaman -->
                              <nav class="flex items-center space-x-4">
                                  {{-- Previous Page Link --}}
                                  @if($articles->onFirstPage())
                                      <span class="px-4 py-2 rounded-lg text-gray-500 cursor-not-allowed border border-gray-600">
                                          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                          </svg>
                                      </span>
                                  @else
                                      <a href="{{ $articles->previousPageUrl() }}@if(request('genre'))&genre={{ request('genre', 'all') }}@endif @if(request('search'))&search={{ request('search') }}@endif" 
                                        class="px-4 py-2 rounded-lg border border-yellow-400 text-yellow-400 hover:bg-yellow-400/10 hover:border-yellow-300 transition-all duration-200 flex items-center">
                                          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                          </svg>
                                          Sebelumnya
                                      </a>
                                  @endif

                                  {{-- Pagination Elements --}}
                                  <div class="flex space-x-3">
                                      @foreach($articles->getUrlRange(1, $articles->lastPage()) as $page => $url)
                                          @if($page == $articles->currentPage())
                                              <span class="px-4 py-2 bg-yellow-400 text-gray-900 rounded-lg border border-yellow-400 font-medium">
                                                  {{ $page }}
                                              </span>
                                          @else
                                              <a href="{{ $url }}@if(request('genre'))&genre={{ request('genre', 'all') }}@endif @if(request('search'))&search={{ request('search') }}@endif" 
                                                class="px-4 py-2 text-yellow-400 hover:bg-yellow-400/10 rounded-lg border border-yellow-400/50 hover:border-yellow-300 transition-all duration-200">
                                                  {{ $page }}
                                              </a>
                                          @endif
                                      @endforeach
                                  </div>

                                  {{-- Next Page Link --}}
                                  @if($articles->hasMorePages())
                                      <a href="{{ $articles->nextPageUrl() }}@if(request('genre'))&genre={{ request('genre', 'all') }}@endif @if(request('search'))&search={{ request('search') }}@endif" 
                                        class="px-4 py-2 rounded-lg border border-yellow-400 text-yellow-400 hover:bg-yellow-400/10 hover:border-yellow-300 transition-all duration-200 flex items-center">
                                          Selanjutnya
                                          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                          </svg>
                                      </a>
                                  @else
                                      <span class="px-4 py-2 rounded-lg text-gray-500 cursor-not-allowed border border-gray-600">
                                          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                          </svg>
                                      </span>
                                  @endif
                              </nav>
                          </div>
                      </div>
                      @endif
                  </div>

                  <!-- Sidebar -->
                  <div class="w-full lg:w-4/12 mt-12 lg:mt-0">
                    <div class="bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-700 sticky top-6">
                        <h3 class="text-xl font-bold text-yellow-300 mb-4 pb-2 border-b border-gray-700">Kategori Populer</h3>
                        <ul class="space-y-3">
                            @php
                                $categories = [
                                    'Budaya & Tradisi' => App\Models\Article::where('genre', 'Budaya & Tradisi')->count(),
                                    'Kearifan Lokal' => App\Models\Article::where('genre', 'Kearifan Lokal')->count(),
                                    'Mitos & Kepercayaan' => App\Models\Article::where('genre', 'Mitos & Kepercayaan')->count(),
                                    'Lokasi' => App\Models\Article::where('genre', 'Lokasi')->count()
                                ];
                            @endphp
                            
                            @foreach($categories as $category => $count)
                            <li>
                                <a href="{{ route('artikel', ['genre' => $category]) }}" 
                                  class="flex items-center justify-between text-gray-300 hover:text-yellow-300 transition-colors group">
                                    <span class="group-hover:underline">{{ $category }}</span>
                                    <span class="bg-yellow-400/10 text-yellow-300 text-xs font-medium px-2.5 py-0.5 rounded-full border border-yellow-400/30 group-hover:bg-yellow-400/20">
                                        {{ $count }}
                                    </span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                  </div>

              </div>
          </div>
        </div>

        <!-- Tombol Tambah Artikel -->
        <div class="fixed bottom-6 right-6 z-[900] md:bottom-8 md:right-8">
          <a href="{{ route('artikel.create') }}" 
              class="group relative flex items-center justify-center gap-3 h-16 w-16 md:h-14 md:w-14 bg-gradient-to-br from-blue-600 to-blue-800 border-2 border-white/20 rounded-lg overflow-hidden transition-all duration-300 ease-in-out shadow-lg hover:shadow-xl hover:from-blue-700 hover:to-blue-900 focus-visible:outline-none">
              
              <!-- Segitiga di pojok kanan atas (dengan warna yang lebih terang) -->
              <div class="absolute top-0 right-0 w-0 h-0 border-r-[1.2rem] border-r-blue-400/80 border-b-[1.2rem] border-b-transparent transition-all duration-200 ease-in-out group-hover:border-r-[8rem] group-hover:border-b-[8rem]"></div>
              
              <!-- Icon Plus -->
              <svg class="w-8 h-8 md:w-6 md:h-6 fill-white transition-all duration-300 ease-in-out group-hover:rotate-180" 
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                  <g mask="url(#mask0_21_345)">
                      <path d="M13.75 23.75V16.25H6.25V13.75H13.75V6.25H16.25V13.75H23.75V16.25H16.25V23.75H13.75Z"></path>
                  </g>
              </svg>
          </a>
        </div>
    </main>

    <footer class="bg-[#262828] text-white py-8 w-full">
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
  
    <!-- Script untuk mobile menu dan search - PERBAIKAN: script yang lebih robust -->
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const button = document.getElementById('mobile-menu-button');
        const menu = document.getElementById('navbar-menu');
        const mobileSearch = document.getElementById('mobile-search');
  
        if (button && menu && mobileSearch) {
          button.addEventListener('click', function() {
            // Toggle menu
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
  
            // Lebih eksplisit untuk search bar
            if (mobileSearch.style.display === 'none') {
              mobileSearch.style.display = 'block';
            } else {
              mobileSearch.style.display = 'none';
            }
  
            // Styling untuk item menu
            const menuItems = menu.querySelectorAll('a');
            menuItems.forEach(item => {
              item.classList.toggle('block');
              item.classList.toggle('mb-2');
              item.classList.toggle('pl-2');
            });
          });
        }
  
        // Highlight current page
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('#navbar-menu a');
        navLinks.forEach(link => {
          if (link.getAttribute('href') === currentPath) {
            link.classList.add('text-yellow-400');
            link.classList.add('font-bold');
          }
        });
      });
    </script>
  
    <!-- Jika pakai Vite, panggilan ini HARUS yang terakhir -->
    @vite(['resources/js/app.js'])
  </body>
  
  </html>