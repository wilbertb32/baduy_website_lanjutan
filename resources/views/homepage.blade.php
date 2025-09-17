<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Basic -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <!-- Site Metas -->
  <title>HomePage Baduy Project</title>
  <meta name="keywords" content="">
  <meta name="description" content="">
  <meta name="author" content="">
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



  <!-- <div class="slider-area">
        <div class="slider-wrapper owl-carousel">
            <div class="slider-item home-one-slider-otem slider-item-four slider-bg-one">
                <div class="container">
                    <div class="row">
                        <div class="slider-content-area">
                            <div class="slide-text">
                                <h1 class="homepage-three-title">Konten <span>Article</span> Slider</h1>
                                <h2>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eius soluta quo, error alias quod facere suscipit deleniti ullam aperiam laudantium ad quis iusto in quae, molestias consectetur eligendi. Sed, delectus. </h2>
                                <div class="slider-content-btn">
                                    <a class="button btn btn-light btn-radius btn-brd" href="#">Read More</a>
                                    <a class="button btn btn-light btn-radius btn-brd" href="#">Contact</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="slider-item text-center home-one-slider-otem slider-item-four slider-bg-two">
                <div class="container">
                    <div class="row">
                        <div class="slider-content-area">
                            <div class="slide-text">
                                <h1 class="homepage-three-title">Konten <span>Article</span> Slider</h1>
                                <h2>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sapiente rem nisi facilis pariatur. Culpa, nihil voluptatibus! Totam accusantium, excepturi vel illo amet ex, distinctio corporis autem itaque sapiente facere qui! </h2>
                                <div class="slider-content-btn">
                                    <a class="button btn btn-light btn-radius btn-brd" href="#">Read More</a>
                                    <a class="button btn btn-light btn-radius btn-brd" href="#">Contact</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="slider-item home-one-slider-otem slider-item-four slider-bg-three">
                <div class="container">
                    <div class="row">
                        <div class="slider-content-area">
                            <div class="slide-text">
                                <h1 class="homepage-three-title">Konten <span>Article</span> Slider</h1>
                                <h2>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Temporibus tempora quasi, reiciendis obcaecati illum quas vero hic est iste, assumenda similique enim beatae adipisci, rerum ut incidunt corporis numquam vitae!</h2>
                                <div class="slider-content-btn">
                                    <a class="button btn btn-light btn-radius btn-brd" href="#">Read More</a>
                                    <a class="button btn btn-light btn-radius btn-brd" href="#">Contact</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

  <main class="flex-grow">
    <div class="relative max-w-7xl mx-auto px-4 py-12">
      <!-- Carousel dinamis - UBAH BAGIAN INI -->
      <div id="carousel" class="overflow-hidden relative">
        <div id="carousel-slides" class="flex transition-transform duration-500 ease-in-out" style="transform: translateX(0%)">
          @forelse($carousels as $carousel)
          <div class="min-w-full flex-shrink-0 p-4">
            <div class="bg-blue-900 rounded-lg overflow-hidden shadow-lg text-center text-black">
              <!-- UBAH: Carousel Image BLOB -->
              @if($carousel->mainImage())
              <img src="{{ route('image.show', $carousel->mainImage()->id) }}" alt="{{ $carousel->title }}" class="w-full h-64 object-cover">
              @else
              <div class="w-full h-64 bg-gray-700 flex items-center justify-center">
                <span class="text-gray-300">No Image</span>
              </div>
              @endif
              <h2 class="mt-4 text-xl font-bold text-yellow-500">{{ $carousel->title }}</h2>
              <p class="mb-4 px-4 text-gray-200">{{ $carousel->description }}</p>
            </div>
          </div>
          @empty
          <div class="min-w-full flex-shrink-0 p-4">
            <div class="bg-blue-900 rounded-lg overflow-hidden shadow-lg text-center text-black">
              <div class="w-full h-64 bg-gray-700 flex items-center justify-center">
                <p class="text-gray-300">No Carousel Available</p>
              </div>
              <h2 class="mt-4 text-xl font-bold text-yellow-500">Suku Baduy</h2>
              <p class="mb-4 px-4 text-gray-200">Traditional Culture</p>
            </div>
          </div>
          @endforelse
        </div>
      </div>
    </div>

    <section class="max-w-7xl mx-auto px-4 py-12">
      <div class="grid md:grid-cols-2 gap-8 items-center">
        <div>
          <h2 class="text-sm text-blue-300 uppercase font-semibold mb-2">About Baduy</h2>
          <h1 class="text-3xl text-yellow-400 font-bold mb-4">Welcome to Suku Baduy</h1>
          <p class="italic text-gray-300 mb-4">
            The Baduy are an indigenous community in Indonesia, living in Banten Province. They are known for their simple and traditional way of life, avoiding modern technology and following strict customs.
          </p>
          <p class="text-gray-300 mb-6">
            The Baduy community, with their rich cultural heritage and long-preserved traditions, seeks to introduce their local wisdom to a wider audience. Through broader promotion, they hope that their traditional values, handcrafted products such as weaving, weaving crafts, and natural goods can become more recognized and appreciated by the general public. This way, not only will their culture remain preserved, but it will also provide economic benefits for their community, opening new opportunities in trade while maintaining the principles of sustainability and environmental preservation that they deeply uphold.
          </p>
          <a href="{{ url('/aboutUs') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Learn More</a>
        </div>
        <div>
          <img src="{{ asset('images/suasana1.jpg') }}" alt="Baduy Group" class="rounded-lg shadow-md">
        </div>
      </div>
    </section>

    <hr class="border-dashed-gray-600 mx-4 my-8">

    <section class="max-w-7xl mx-auto px-4 pb-12">
      <div class="grid md:grid-cols-2 gap-8 items-center">
        <div>
          <img src="{{ asset('images/suasana2.jpg') }}" alt="Baduy Village" class="rounded-lg shadow-md">
        </div>
        <div>
          <h2 class="text-sm text-blue-300 uppercase font-semibold mb-2">Article</h2>
          <h1 class="text-2xl text-yellow-400 font-bold mb-4">Suasana Bersama di Suku Baduy</h1>
          <p class="italic text-gray-300 mb-4">
            Gambar ini menampilkan suasana kebersamaan masyarakat Baduy yang sedang berkumpul di area terbuka dengan suasana yang tenang dan alami. Mereka mengenakan pakaian adat khas Baduy, mencerminkan kekompakan dan kedekatan dengan tradisi.
          </p>
          <p class="text-gray-300 mb-6">
            Di sekitar mereka, terlihat lingkungan yang masih alami dan asri, dengan pepohonan yang tumbuh subur di sekeliling tempat mereka berkumpul. Jalan setapak yang terbuat dari batu besar memberikan kesan alami, menghubungkan rumah-rumah adat Baduy yang juga menggunakan bahan-bahan alami untuk konstruksinya. Lingkungan sekitar yang hijau dan alami menambah kehangatan dalam interaksi mereka, menggambarkan kehidupan sederhana namun penuh makna.
          </p>
          <a href="{{ url('/artikel') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Learn More</a>
        </div>
      </div>
    </section>

    <section class="bg-cover bg-center py-16 bg-[url('{{asset('images/suasana1.jpg')}}')]">
      <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
          @forelse($products as $product)
          <!-- Dynamic Product Item -->
          <div class="relative bg-white shadow rounded overflow-hidden">
            <!-- UBAH: Product Image BLOB -->
            @if($product->mainImage())
            <img src="{{ route('image.show', $product->mainImage()->id) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
            @else
            <div class="w-full h-48 bg-gray-300 flex items-center justify-center">
              <span class="text-gray-500">No Image</span>
            </div>
            @endif
            <div class="bg-blue-600 text-center py-2">
              <p class="text-yellow-400 font-bold">{{ $product->name }}</p>
            </div>
          </div>
          @empty
          <!-- Fallback for no products -->
          <div class="col-span-4 text-center py-8">
            <p class="text-white text-lg font-bold">No products available at the moment.</p>
          </div>
          @endforelse
        </div>

        <!-- View All Products Button -->
        <div class="text-center mt-8">
          <a href="{{ url('/marketplace') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded transition">
            View All Products
          </a>
        </div>
      </div>
    </section>
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

  <a href="#" id="scroll-to-top" class="dmtop global-radius"><i class="fa fa-angle-up"></i></a>

  <!-- JS FILES -->
  <script>
document.addEventListener('DOMContentLoaded', function() {
  // Mobile menu functionality (sama seperti di atas)
  const button = document.getElementById('mobile-menu-button');
  const menu = document.getElementById('navbar-menu');

  if (button && menu) {
    button.addEventListener('click', function() {
      menu.classList.toggle('hidden');
      menu.classList.toggle('flex');
      menu.classList.toggle('flex-col');
      menu.classList.toggle('absolute');
      menu.classList.toggle('top-16');
      menu.classList.toggle('right-0');
      menu.classList.toggle('text-right');
      menu.classList.toggle('bg-gray-800');
      menu.classList.toggle('p-4');
      menu.classList.toggle('rounded');
      menu.classList.toggle('shadow-lg');
      menu.classList.toggle('z-10');

      const menuItems = menu.querySelectorAll('a');
      menuItems.forEach(item => {
        item.classList.toggle('block');
        item.classList.toggle('mb-2');
        item.classList.toggle('pl-2');
      });
    });
  }

  // Auto-only Carousel with hover pause
  const carousel = document.getElementById('carousel');
  const slides = document.getElementById('carousel-slides');
  const slideCount = slides ? slides.children.length : 0;
  let currentSlide = 0;
  let autoSlideInterval;

  function updateSlidePosition() {
    if (slides && slideCount > 0) {
      slides.style.transform = `translateX(-${currentSlide * 100}%)`;
    }
  }

  function startAutoSlide() {
    if (slideCount > 1) {
      autoSlideInterval = setInterval(function() {
        currentSlide = (currentSlide + 1) % slideCount;
        updateSlidePosition();
      }, 5000);
    }
  }

  function stopAutoSlide() {
    if (autoSlideInterval) {
      clearInterval(autoSlideInterval);
    }
  }

  // Start auto-slide
  startAutoSlide();

  // Pause on hover (optional)
  if (carousel && slideCount > 1) {
    carousel.addEventListener('mouseenter', stopAutoSlide);
    carousel.addEventListener('mouseleave', startAutoSlide);
  }
});
</script>

  @vite(['resources/js/app.js'])

</body>

</html>