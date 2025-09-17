<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard - Baduy</title>
    <link rel="shortcut icon" href="{{ asset('images/logobadui1.webp') }}" type="image/png" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <!-- Header/Navbar -->
    <header class="bg-gray-800 text-white shadow">
        <div class="container mx-auto flex justify-between items-center p-4">
            <div class="flex items-center space-x-4">
                <img src="{{ asset('images/logobadui1.webp') }}" class="h-10 w-auto" alt="Baduy Logo">
                <h1 class="text-xl font-bold">Super Admin Dashboard</h1>
            </div>
            <div class="flex items-center space-x-4">
                <span>Selamat Datang, {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-sm">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content - SINKRONKAN x-data dengan admin -->
    <div class="container mx-auto px-4 py-8" x-data="{ 
        activeTab: '{{ session('active_tab', 'products') }}', 
        activeArticleTab: '{{ session('active_article_tab', 'pending') }}',
        showRejectModal: false, 
        rejectArticleId: null,
        showAddProductModal: false, 
        showEditProductModal: false, 
        showAddCarouselModal: false, 
        showEditCarouselModal: false, 
        editProductId: null, 
        editCarouselId: null,
        showAddAdminModal: false
    }">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Sidebar -->
            <div class="w-full md:w-1/4 bg-white rounded-lg shadow p-4">
                <h2 class="text-lg font-semibold mb-4 text-gray-800">Menu Super Admin</h2>
                <nav>
                    <ul class="space-y-2">
                        <li>
                            <a href="#"
                                class="block py-2 px-4 rounded"
                                :class="{ 'bg-gray-800 text-white': activeTab === 'products', 'hover:bg-gray-200 text-gray-800': activeTab !== 'products' }"
                                @click.prevent="activeTab = 'products'">
                                Kelola Produk
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="block py-2 px-4 rounded"
                                :class="{ 'bg-gray-800 text-white': activeTab === 'carousel', 'hover:bg-gray-200 text-gray-800': activeTab !== 'carousel' }"
                                @click.prevent="activeTab = 'carousel'">
                                Kelola Carousel
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="block py-2 px-4 rounded"
                                :class="{ 'bg-gray-800 text-white': activeTab === 'articles', 'hover:bg-gray-200 text-gray-800': activeTab !== 'articles' }"
                                @click.prevent="activeTab = 'articles'">
                                Kelola Artikel
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="block py-2 px-4 rounded"
                                :class="{ 'bg-gray-800 text-white': activeTab === 'adminUsers', 'hover:bg-gray-200 text-gray-800': activeTab !== 'adminUsers' }"
                                @click.prevent="activeTab = 'adminUsers'">
                                Kelola Admin
                            </a>
                        </li>

                        <!-- divider -->
                        <li class="border-t border-gray-200 my-3 pt-3">
                            <a href="{{ url('/') }}" class="py-2 px-4 rounded hover:bg-gray-200 text-gray-800 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                Lihat Website
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Main Panel -->
            <div class="w-full md:w-3/4">
                <!-- Products Tab - COPY EXACT DARI ADMIN -->
                <div x-show="activeTab === 'products'">
                    <div class="bg-white rounded-lg shadow p-6 mb-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold text-gray-800">Kelola Produk</h2>
                            <button type="button"
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded"
                                @click="showAddProductModal = true">
                                Tambah Produk
                            </button>
                        </div>

                        <!-- Success product Message -->
                        @if(session('success') && !session('article_success') && !session('admin_success'))
                        <div x-show="activeTab === 'products'" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                        @endif

                        <!-- Products Table - COPY EXACT DARI ADMIN -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 border">ID</th>
                                        <th class="px-4 py-2 border">Gambar</th>
                                        <th class="px-4 py-2 border">Nama Produk</th>
                                        <th class="px-4 py-2 border">Deskripsi</th>
                                        <th class="px-4 py-2 border">Harga</th>
                                        <th class="px-4 py-2 border">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($products ?? [] as $product)
                                    <tr>
                                        <td class="px-4 py-2 border text-center">{{ $product->id }}</td>
                                        <td class="px-4 py-2 border">
                                            <!-- UBAH: Product Image BLOB -->
                                            @if($product->mainImage())
                                            <img src="{{ route('image.show', $product->mainImage()->id) }}"
                                                alt="{{ $product->name }}" class="h-16 w-16 object-cover mx-auto">
                                            @else
                                            <div class="h-16 w-16 bg-gray-300 flex items-center justify-center mx-auto rounded">
                                                <span class="text-gray-500 text-xs">No Image</span>
                                            </div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2 border">{{ $product->name }}</td>
                                        <td class="px-4 py-2 border">{{ Str::limit($product->description, 50) }}</td>
                                        <td class="px-4 py-2 border">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                        <td class="px-4 py-2 border">
                                            <div class="flex space-x-2 justify-center">
                                                <button class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-sm edit-product-btn"
                                                    @click="showEditProductModal = true; editProductId = {{ $product->id }}; 
                                                        document.getElementById('editProductForm').action = '{{ url('admin/products') }}/{{ $product->id }}';
                                                        document.getElementById('edit_name').value = '{{ $product->name }}';
                                                        document.getElementById('edit_description').value = '{{ $product->description }}';
                                                        document.getElementById('edit_price').value = '{{ $product->price }}';
                                                        @if($product->mainImage())
                                                            document.getElementById('current_product_image').src = '{{ route('image.show', $product->mainImage()->id) }}';
                                                        @else
                                                            document.getElementById('current_product_image').style.display = 'none';
                                                        @endif">
                                                    Edit
                                                </button>
                                                <form method="POST" action="{{ route('products.destroy', $product->id) }}"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-sm">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-2 text-center border">Belum ada produk</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Carousel Tab - COPY EXACT DARI ADMIN -->
                <div x-show="activeTab === 'carousel'">
                    <div class="bg-white rounded-lg shadow p-6 mb-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold text-gray-800">Kelola Carousel Homepage</h2>
                            <button type="button"
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded"
                                @click="showAddCarouselModal = true">
                                Tambah Slide
                            </button>
                        </div>

                        <!-- Carousel Images Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 border">ID</th>
                                        <th class="px-4 py-2 border">Gambar</th>
                                        <th class="px-4 py-2 border">Judul</th>
                                        <th class="px-4 py-2 border">Deskripsi</th>
                                        <th class="px-4 py-2 border">Urutan</th>
                                        <th class="px-4 py-2 border">Aksi</th>
                                    </tr>
                                </thead>
                                <!-- Carousel Items Table Body -->
                                <tbody>
                                    @forelse($carousels ?? [] as $carousel)
                                    <tr>
                                        <td class="px-4 py-2 border text-center">{{ $carousel->id }}</td>
                                        <td class="px-4 py-2 border">
                                            <!-- UBAH: Carousel Image BLOB -->
                                            @if($carousel->mainImage())
                                            <img src="{{ route('image.show', $carousel->mainImage()->id) }}"
                                                alt="{{ $carousel->title }}" class="h-16 w-28 object-cover mx-auto">
                                            @else
                                            <div class="h-16 w-28 bg-gray-300 flex items-center justify-center mx-auto rounded">
                                                <span class="text-gray-500 text-xs">No Image</span>
                                            </div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2 border">{{ $carousel->title }}</td>
                                        <td class="px-4 py-2 border">{{ Str::limit($carousel->description, 50) }}</td>
                                        <td class="px-4 py-2 border text-center">{{ $carousel->order }}</td>
                                        <td class="px-4 py-2 border">
                                            <div class="flex space-x-2 justify-center">
                                                <button class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-sm"
                                                    @click="showEditCarouselModal = true; editCarouselId = {{ $carousel->id }};
                                                        document.getElementById('editCarouselForm').action = '{{ url('admin/carousels') }}/{{ $carousel->id }}';
                                                        document.getElementById('edit_carousel_title').value = '{{ $carousel->title }}';
                                                        document.getElementById('edit_carousel_description').value = '{{ $carousel->description }}';
                                                        document.getElementById('edit_order').value = '{{ $carousel->order }}';
                                                        @if($carousel->mainImage())
                                                            document.getElementById('current_carousel_image').src = '{{ route('image.show', $carousel->mainImage()->id) }}';
                                                        @else
                                                            document.getElementById('current_carousel_image').style.display = 'none';
                                                        @endif">
                                                    Edit
                                                </button>
                                                <form method="POST" action="{{ route('carousels.destroy', $carousel->id) }}"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus slide ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-sm">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-2 text-center border">Belum ada item carousel</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Artikel tab - SINKRONKAN DENGAN ADMIN 3 TAB -->
                <div x-show="activeTab === 'articles'">
                    <div class="bg-white rounded-lg shadow p-6 mb-6">
                        <!-- Notifikasi Artikel -->
                        @if(session('article_success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            <p>{{ session('article_success') }}</p>
                        </div>
                        @endif

                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold text-gray-800">Kelola Artikel</h2>
                        </div>

                        <!-- Tab Navigasi - TAMBAH TAB KETIGA -->
                        <div class="mb-6 border-b border-gray-200">
                            <ul class="flex flex-wrap -mb-px">
                                <li class="mr-2">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg"
                                        :class="{ 
                                                'border-[#6d6d4f] text-[#6d6d4f]': activeArticleTab === 'pending', 
                                                'border-transparent hover:text-gray-600 hover:border-gray-300': activeArticleTab !== 'pending' 
                                            }"
                                        @click="activeArticleTab = 'pending'">
                                        Menunggu Approval ({{ $pendingArticles->count() }})
                                    </button>
                                </li>
                                <li class="mr-2">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg"
                                        :class="{ 
                                                'border-[#6d6d4f] text-[#6d6d4f]': activeArticleTab === 'approved', 
                                                'border-transparent hover:text-gray-600 hover:border-gray-300': activeArticleTab !== 'approved' 
                                            }"
                                        @click="activeArticleTab = 'approved'">
                                        Artikel Disetujui ({{ $approvedArticles->count() }})
                                    </button>
                                </li>
                                <li class="mr-2">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg"
                                        :class="{ 
                                                'border-[#6d6d4f] text-[#6d6d4f]': activeArticleTab === 'rejected', 
                                                'border-transparent hover:text-gray-600 hover:border-gray-300': activeArticleTab !== 'rejected' 
                                            }"
                                        @click="activeArticleTab = 'rejected'">
                                        Artikel Ditolak ({{ $rejectedArticles->count() }})
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <!-- Tab Content - Pending Articles -->
                        <div x-show="activeArticleTab === 'pending'" class="bg-white rounded-lg">
                            @if($pendingArticles->isEmpty())
                            <div class="text-center py-8 text-gray-500">
                                Tidak ada artikel yang menunggu persetujuan
                            </div>
                            @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white border border-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 border">Judul</th>
                                            <th class="px-4 py-3 border">Penulis</th>
                                            <th class="px-4 py-3 border">Kategori</th>
                                            <th class="px-4 py-3 border">Tanggal</th>
                                            <th class="px-4 py-3 border">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pendingArticles as $article)
                                        <tr>
                                            <td class="px-4 py-3 border">{{ Str::limit($article->title, 40) }}</td>
                                            <td class="px-4 py-3 border">{{ $article->user->name }}</td>
                                            <td class="px-4 py-3 border">{{ $article->genre }}</td>
                                            <td class="px-4 py-3 border">{{ $article->created_at->format('d M Y') }}</td>
                                            <td class="px-4 py-3 border">
                                                <div class="flex space-x-2 justify-center">
                                                    <a href="{{ route('artikel.show', $article->id) }}"
                                                        target="_blank"
                                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                                        Lihat
                                                    </a>
                                                    <form method="POST" action="{{ route('superadmin.articles.approve', $article->id) }}">
                                                        @csrf
                                                        <button type="submit"
                                                            onclick="return confirm('Apakah Anda yakin ingin menyetujui artikel ini?')"
                                                            class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                                                            Setujui
                                                        </button>
                                                    </form>
                                                    <button @click="showRejectModal = true; rejectArticleId = {{ $article->id }}"
                                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                                        Tolak
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>

                        <!-- Tab Content - Approved Articles -->
                        <div x-show="activeArticleTab === 'approved'" class="bg-white rounded-lg">
                            @if($approvedArticles->isEmpty())
                            <div class="text-center py-8 text-gray-500">
                                Belum ada artikel yang disetujui
                            </div>
                            @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white border border-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 border">Judul</th>
                                            <th class="px-4 py-3 border">Penulis</th>
                                            <th class="px-4 py-3 border">Kategori</th>
                                            <th class="px-4 py-3 border">Tanggal Disetujui</th>
                                            <th class="px-4 py-3 border">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($approvedArticles as $article)
                                        <tr>
                                            <td class="px-4 py-3 border">{{ Str::limit($article->title, 40) }}</td>
                                            <td class="px-4 py-3 border">{{ $article->user->name }}</td>
                                            <td class="px-4 py-3 border">{{ $article->genre }}</td>
                                            <td class="px-4 py-3 border">{{ $article->approved_at ? $article->approved_at->format('d M Y') : '-' }}</td>
                                            <td class="px-4 py-3 border">
                                                <div class="flex space-x-2 justify-center">
                                                    <a href="{{ route('artikel.show', $article->id) }}"
                                                        target="_blank"
                                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                                        Lihat
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>

                        <!-- Tab Content - Rejected Articles (BARU) -->
                        <div x-show="activeArticleTab === 'rejected'" class="bg-white rounded-lg">
                            @if($rejectedArticles->isEmpty())
                            <div class="text-center py-8 text-gray-500">
                                Belum ada artikel yang ditolak
                            </div>
                            @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white border border-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 border">Judul</th>
                                            <th class="px-4 py-3 border">Penulis</th>
                                            <th class="px-4 py-3 border">Kategori</th>
                                            <th class="px-4 py-3 border">Tanggal Ditolak</th>
                                            <th class="px-4 py-3 border">Alasan Penolakan</th>
                                            <th class="px-4 py-3 border">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($rejectedArticles as $article)
                                        <tr>
                                            <td class="px-4 py-3 border">{{ Str::limit($article->title, 40) }}</td>
                                            <td class="px-4 py-3 border">{{ $article->user->name }}</td>
                                            <td class="px-4 py-3 border">{{ $article->genre }}</td>
                                            <td class="px-4 py-3 border">{{ $article->reviewed_at ? $article->reviewed_at->format('d M Y') : '-' }}</td>
                                            <td class="px-4 py-3 border">
                                                <div class="max-w-xs">
                                                    <p class="text-sm text-red-600">{{ Str::limit($article->rejection_reason, 50) }}</p>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 border">
                                                <div class="flex space-x-2 justify-center">
                                                    <a href="{{ route('artikel.show', $article->id) }}"
                                                        target="_blank"
                                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                                        Lihat
                                                    </a>
                                                    <!-- Tombol untuk menyetujui artikel yang ditolak -->
                                                    <form method="POST" action="{{ route('superadmin.articles.approve', $article->id) }}">
                                                        @csrf
                                                        <button type="submit"
                                                            onclick="return confirm('Apakah Anda yakin ingin menyetujui artikel yang sebelumnya ditolak ini?')"
                                                            class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                                                            Setujui
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Admin Users Management Tab - TIDAK BERUBAH -->
                <div x-show="activeTab === 'adminUsers'">
                    <div class="bg-white rounded-lg shadow p-6 mb-6">
                        <!-- Notifikasi Admin -->
                        @if(session('admin_success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            <p>{{ session('admin_success') }}</p>
                        </div>
                        @endif

                        @if(session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                            <p>{{ session('error') }}</p>
                        </div>
                        @endif

                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold text-gray-800">Kelola User & Admin</h2>
                            <button type="button"
                                class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded"
                                @click="showAddAdminModal = true">
                                Tambah Admin Baru
                            </button>
                        </div>

                        <!-- Admin Users Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 border">Foto</th>
                                        <th class="px-4 py-3 border">Nama</th>
                                        <th class="px-4 py-3 border">Email</th>
                                        <th class="px-4 py-3 border">Role</th>
                                        <th class="px-4 py-3 border">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users ?? [] as $user)
                                    <tr>
                                        <td class="px-4 py-3 border">
                                            <div class="flex-shrink-0 h-10 w-10 mx-auto">
                                                <img class="h-10 w-10 rounded-full object-cover"
                                                    src="{{ $user->profile_photo_url }}"
                                                    alt="{{ $user->name }}">
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 border">{{ $user->name }}</td>
                                        <td class="px-4 py-3 border">{{ $user->email }}</td>
                                        <td class="px-4 py-3 border">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-800' : 
                                                  ($user->role == 'superadmin' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 border">
                                            @if($user->role != 'superadmin')
                                            <form method="POST" action="{{ route('roles.update', $user->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="flex items-center space-x-2 justify-center">
                                                    <select name="role" class="border border-gray-300 rounded text-sm px-2 py-1 text-gray-700">
                                                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                                    </select>
                                                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-sm">
                                                        Update
                                                    </button>
                                                </div>
                                            </form>
                                            @else
                                            <span class="text-xs text-gray-500 italic">Superadmin</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-3 text-center border">Belum ada data pengguna</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Add Admin Modal -->
                <div x-show="showAddAdminModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                    <div class="bg-white rounded-lg p-8 max-w-md w-full">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-bold text-gray-800">Tambah Admin Baru</h3>
                            <button type="button" class="text-gray-600 hover:text-gray-800"
                                @click="showAddAdminModal = false">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <form action="{{ route('roles.promote') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email Pengguna:</label>
                                <input type="email" id="email" name="email" placeholder="Masukkan email pengguna yang akan dijadikan admin"
                                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <p class="text-xs text-gray-500 mt-1">Pengguna harus sudah terdaftar dalam sistem</p>
                            </div>

                            <div class="flex justify-end space-x-4">
                                <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded"
                                    @click="showAddAdminModal = false">
                                    Batal
                                </button>
                                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded">
                                    Jadikan Admin
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Reject Modal - SINKRONKAN DENGAN ADMIN -->
                <div x-show="showRejectModal"
                    x-cloak
                    class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                    <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Tolak Artikel</h3>
                        <form method="POST" :action="`{{ url('superadmin/articles') }}/${rejectArticleId}/reject`">
                            @csrf
                            <div class="mb-4">
                                <label for="reason" class="block text-gray-700 text-sm font-bold mb-2">Alasan Penolakan:</label>
                                <textarea id="reason" name="reason" rows="4"
                                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Masukkan alasan mengapa artikel ini ditolak..."
                                    required></textarea>
                            </div>
                            <div class="flex justify-end space-x-4">
                                <button type="button"
                                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded"
                                    @click="showRejectModal = false; document.getElementById('reason').value = '';">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                                    Tolak Artikel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Add Product Modal - INPUT UNTUK BLOB -->
                <div x-show="showAddProductModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                    <div class="bg-white rounded-lg p-8 max-w-md w-full max-h-screen overflow-y-auto">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-bold text-gray-800">Tambah Produk Baru</h3>
                            <button type="button" class="text-gray-600 hover:text-gray-800"
                                @click="showAddProductModal = false">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Produk:</label>
                                <input type="text" id="name" name="name" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>

                            <div class="mb-4">
                                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi:</label>
                                <textarea id="description" name="description" rows="3" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                            </div>

                            <div class="mb-4">
                                <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Harga (Rp):</label>
                                <input type="number" id="price" name="price" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>

                            <div class="mb-4">
                                <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Gambar Produk:</label>
                                <input type="file" id="image" name="image" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" accept="image/*" required>
                                <p class="text-sm text-gray-500 mt-1">Gambar akan disimpan sebagai BLOB. Format: JPG, PNG, JPEG. Maksimal 2MB.</p>
                            </div>

                            <div class="flex justify-end space-x-4">
                                <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded"
                                    @click="showAddProductModal = false">
                                    Batal
                                </button>
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Edit Product Modal - EDIT BLOB -->
                <div x-show="showEditProductModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                    <div class="bg-white rounded-lg p-8 max-w-md w-full max-h-screen overflow-y-auto">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-bold text-gray-800">Edit Produk</h3>
                            <button type="button" class="text-gray-600 hover:text-gray-800"
                                @click="showEditProductModal = false">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <form action="{{ url('products/1') }}" id="editProductForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="edit_name" class="block text-gray-700 text-sm font-bold mb-2">Nama Produk:</label>
                                <input type="text" id="edit_name" name="name" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>

                            <div class="mb-4">
                                <label for="edit_description" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi:</label>
                                <textarea id="edit_description" name="description" rows="3" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                            </div>

                            <div class="mb-4">
                                <label for="edit_price" class="block text-gray-700 text-sm font-bold mb-2">Harga (Rp):</label>
                                <input type="number" id="edit_price" name="price" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Gambar Saat Ini (BLOB):</label>
                                <img id="current_product_image" src="" alt="Current Image" class="h-32 w-32 object-cover rounded mb-2">
                                <label for="edit_image" class="block text-gray-700 text-sm font-bold mb-2">Ganti Gambar (opsional):</label>
                                <input type="file" id="edit_image" name="image" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" accept="image/*">
                                <p class="text-sm text-gray-500 mt-1">Gambar baru akan mengganti yang lama di database BLOB.</p>
                            </div>

                            <div class="flex justify-end space-x-4">
                                <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded"
                                    @click="showEditProductModal = false">
                                    Batal
                                </button>
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                    Perbarui
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Add Carousel Modal - INPUT UNTUK BLOB -->
                <div x-show="showAddCarouselModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                    <div class="bg-white rounded-lg p-8 max-w-md w-full max-h-screen overflow-y-auto">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-bold text-gray-800">Tambah Slide Carousel</h3>
                            <button type="button" class="text-gray-600 hover:text-gray-800"
                                @click="showAddCarouselModal = false">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <form action="{{ route('carousels.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Judul Slide:</label>
                                <input type="text" id="title" name="title" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>

                            <div class="mb-4">
                                <label for="carousel_description" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi:</label>
                                <textarea id="carousel_description" name="description" rows="3" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                            </div>

                            <div class="mb-4">
                                <label for="order" class="block text-gray-700 text-sm font-bold mb-2">Urutan:</label>
                                <input type="number" id="order" name="order" min="1" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>

                            <div class="mb-4">
                                <label for="carousel_image" class="block text-gray-700 text-sm font-bold mb-2">Gambar Slide:</label>
                                <input type="file" id="carousel_image" name="image" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" accept="image/*" required>
                                <p class="text-sm text-gray-500 mt-1">Gambar akan disimpan sebagai BLOB. Format: JPG, PNG, JPEG. Maksimal 2MB.</p>
                            </div>

                            <div class="flex justify-end space-x-4">
                                <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded"
                                    @click="showAddCarouselModal = false">
                                    Batal
                                </button>
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Edit Carousel Modal - EDIT BLOB -->
                <div x-show="showEditCarouselModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                    <div class="bg-white rounded-lg p-8 max-w-md w-full max-h-screen overflow-y-auto">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-bold text-gray-800">Edit Slide Carousel</h3>
                            <button type="button" class="text-gray-600 hover:text-gray-800"
                                @click="showEditCarouselModal = false">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <form action="{{ url('carousels/1') }}" id="editCarouselForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="edit_carousel_title" class="block text-gray-700 text-sm font-bold mb-2">Judul Slide:</label>
                                <input type="text" id="edit_carousel_title" name="title" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>

                            <div class="mb-4">
                                <label for="edit_carousel_description" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi:</label>
                                <textarea id="edit_carousel_description" name="description" rows="3" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                            </div>

                            <div class="mb-4">
                                <label for="edit_order" class="block text-gray-700 text-sm font-bold mb-2">Urutan:</label>
                                <input type="number" id="edit_order" name="order" min="1" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Gambar Saat Ini (BLOB):</label>
                                <img id="current_carousel_image" src="" alt="Current Image" class="h-32 w-60 object-cover rounded mb-2">
                                <label for="edit_carousel_image" class="block text-gray-700 text-sm font-bold mb-2">Ganti Gambar (opsional):</label>
                                <input type="file" id="edit_carousel_image" name="image" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" accept="image/*">
                                <p class="text-sm text-gray-500 mt-1">Gambar baru akan mengganti yang lama di database BLOB.</p>
                            </div>

                            <div class="flex justify-end space-x-4">
                                <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded"
                                    @click="showEditCarouselModal = false">
                                    Batal
                                </button>
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                    Perbarui
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @vite(['resources/js/app.js'])
</body>

</html>