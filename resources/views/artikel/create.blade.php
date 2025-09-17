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

  <!-- Text Editor Tambahan -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css">
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script>

</head>

<body class="bg-gray-100">
  <header
    x-data="{ scrolled: false, mobileMenuOpen: false }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.pageYOffset > 20 })"
    :class="scrolled
    ? 'bg-gray-800 bg-opacity-90 backdrop-blur-md shadow-md'
    : 'bg-gray-800'"
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

  <div class="min-h-screen bg-gradient-to-br from-[#305792] to-[#313a4d]">
    <div class="max-w-4xl mx-auto px-1 py-12">
      <div class="bg-white/90 backdrop-blur-lg rounded-2xl shadow-2xl p-8 md:p-12 transition-all duration-300 hover:shadow-3xl">
        <h2 class="text-4xl font-bold text-center mb-8 bg-gradient-to-r from-[#305792] to-[#4CAF50] bg-clip-text text-transparent">
          ✏️ Buat Artikel Baru
        </h2>

        <form action="{{ route('artikel.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <!-- Input Judul -->
          <div class="space-y-2">
            <label class="block text-lg font-medium text-gray-700">Judul Artikel</label>
            <input type="text" id="title" name="title" required
              class="w-full px-6 py-4 border-2 border-gray-200 rounded-xl text-lg focus:border-[#4CAF50] focus:ring-2 focus:ring-[#4CAF50]/30 transition-all placeholder-gray-400"
              placeholder="Masukkan judul menarik disini...">
          </div>

          <!-- Input Kategori -->
          <div class="space-y-2">
            <label class="block text-lg font-medium text-gray-700">Kategori Artikel</label>
            <div class="relative">
              <select id="genre" name="genre" required
                class="w-full px-6 py-4 border-2 border-gray-200 rounded-xl appearance-none bg-white text-lg focus:border-[#4CAF50] focus:ring-2 focus:ring-[#4CAF50]/30 transition-all">
                <option value="">Pilih Kategori</option>
                <option value="Budaya & Tradisi">Budaya & Tradisi</option>
                <option value="Kearifan Lokal">Kearifan Lokal</option>
                <option value="Mitos & Kepercayaan">Mitos & Kepercayaan</option>
                <option value="Lokasi">Lokasi</option>
              </select>
              <div class="absolute inset-y-0 right-6 flex items-center pointer-events-none">
                <svg class="w-1 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Input Gambar Header -->
          <div class="space-y-2">
            <label class="block text-lg font-medium text-gray-700">Upload Gambar Header</label>
            <input type="file" id="header_image" name="header_image" accept="image/*"
              class="w-full px-6 py-4 border-2 border-gray-200 rounded-xl text-lg focus:border-[#4CAF50] focus:ring-2 focus:ring-[#4CAF50]/30 transition-all">
            <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, JPEG, WEBP. Maksimal 2MB. Gambar akan dikompres otomatis.</p>
            @error('header_image')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
          </div>

          <!-- Input Gallery Images -->
          <div class="space-y-2">
            <label class="block text-lg font-medium text-gray-700">Upload Gambar Gallery (Opsional)</label>
            <input type="file" id="gallery_images" name="gallery_images[]" accept="image/*" multiple
              class="w-full px-6 py-4 border-2 border-gray-200 rounded-xl text-lg focus:border-[#4CAF50] focus:ring-2 focus:ring-[#4CAF50]/30 transition-all">
            <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, JPEG, WEBP. Maksimal 1MB per gambar. Gambar akan dikompres otomatis.</p>
            @error('gallery_images.*')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
          </div>

          <!-- Input Konten -->
          <div class="space-y-2">
            <label class="block text-lg font-medium text-gray-700">Isi Artikel</label>
            <input id="content" type="hidden" name="content">
            <trix-editor
              input="content"
              class="trix-content bg-white rounded-xl p-4 border-2 border-gray-200"
              data-trix-remove-attachment-button="true"
              data-trix-remove-code-button="true"></trix-editor>
          </div>

          <!-- REMINDER -->
          <div class="mt-6 mb-6 p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded-lg">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
              </div>
              <div class="ml-3">
                <p class="text-sm text-yellow-700 font-medium">
                  <span class="font-bold">REMINDER:</span> Artikel tidak akan bisa di edit lagi, pastikan semua kata-kata sudah sesuai dengan keinginan Anda!
                </p>
              </div>
            </div>
          </div>

          <!-- Tombol Submit -->
          <button type="submit"
            class="w-full py-5 px-8 bg-gradient-to-r from-[#4CAF50] to-[#305792] text-white text-xl font-semibold rounded-xl shadow-lg hover:shadow-xl hover:scale-[1.02] transition-all transform duration-300 active:scale-95">
            📤 Publikasikan Sekarang
          </button>
        </form>
      </div>
    </div>
  </div>

  <style>
    /* Sembunyikan tombol attachment dan code */
    trix-toolbar .trix-button-group--file-tools,
    trix-toolbar .trix-button--icon-code,
    trix-toolbar .trix-button--icon-attach {
      display: none !important;
    }

    /* Style tambahan untuk editor */
    .trix-content {
      min-height: 300px;
    }

    .trix-content h1 {
      font-size: 1.8rem;
      font-weight: bold;
      margin: 1.5rem 0 1rem;
    }

    .trix-content ul,
    .trix-content ol {
      padding-left: 2rem;
      margin: 1rem 0;
    }

    .trix-content a {
      color: #305792;
      text-decoration: underline;
    }
  </style>

  <script>
    document.addEventListener('trix-initialize', function(event) {
      // Nonaktifkan fitur attachment
      event.target.editor.element.removeAttribute('data-trix-attachment');

      // Hapus tombol yang tidak diinginkan
      const toolbar = event.target.toolbarElement;
      const fileTools = toolbar.querySelector('.trix-button-group--file-tools');
      if (fileTools) fileTools.remove();

      const codeButton = toolbar.querySelector('.trix-button--icon-code');
      if (codeButton) codeButton.remove();

      // Blok upload file
      event.target.editor.element.addEventListener('trix-file-accept', function(e) {
        e.preventDefault();
      });
    });
  </script>
</body>

</html>