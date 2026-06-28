<x-admin-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-slate-900">Edit Produk</h2>
            <p class="mt-1 text-sm text-slate-500">Perbarui detail produk dan sesuaikan data stok atau harga terbaru.</p>
        </div>
    </x-slot>

    <div class="mx-auto max-w-5xl">
        <div class="grid gap-6 xl:grid-cols-3">
            <div class="xl:col-span-2 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <form action="{{ route('karyawan.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Image Upload --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Gambar produk</label>
                        <div x-data="imageUploadEdit('{{ $product->image ? asset('storage/' . $product->image) : '' }}', '{{ $product->image ? basename($product->image) : '' }}')" class="relative">
                            {{-- Drop zone (shown when no preview) --}}
                            <div
                                x-show="!preview"
                                @dragover.prevent="isDragging = true"
                                @dragleave.prevent="isDragging = false"
                                @drop.prevent="handleDrop($event)"
                                @click="$refs.fileInput.click()"
                                :class="isDragging ? 'border-[#E85D40] bg-orange-50' : 'border-slate-300 bg-slate-50 hover:bg-slate-100'"
                                class="relative flex flex-col items-center justify-center rounded-2xl border-2 border-dashed cursor-pointer transition-all duration-200 py-10 px-6">
                                <div class="flex flex-col items-center text-center">
                                    <div class="mb-3 rounded-full bg-white p-3 shadow-sm">
                                        <svg class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-700">Klik atau seret gambar ke sini</p>
                                    <p class="mt-1 text-xs text-slate-500">JPG, PNG, atau WEBP • Maksimal 2MB</p>
                                </div>
                            </div>

                            {{-- Preview (existing or new) --}}
                            <div x-show="preview" x-cloak class="relative rounded-2xl overflow-hidden border border-slate-200 bg-slate-50">
                                <img :src="preview" class="w-full h-64 object-contain bg-white" alt="Preview">
                                <div class="absolute top-3 right-3 flex gap-2">
                                    <button type="button" @click="$refs.fileInput.click()" class="rounded-full bg-white/90 backdrop-blur-sm p-2 text-slate-600 shadow-lg hover:bg-slate-100 transition" title="Ganti gambar">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    </button>
                                    <button type="button" @click="removeImage()" class="rounded-full bg-white/90 backdrop-blur-sm p-2 text-rose-600 shadow-lg hover:bg-rose-50 transition" title="Hapus gambar">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </div>
                                <div class="px-4 py-2 bg-slate-50 border-t border-slate-200">
                                    <p class="text-xs text-slate-600 font-medium truncate" x-text="fileName"></p>
                                    <p class="text-[10px] text-slate-400" x-text="fileSize || 'Gambar tersimpan'"></p>
                                </div>
                            </div>

                            <input x-ref="fileInput" type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="hidden" @change="handleFileSelect($event)">
                            <input type="hidden" name="remove_image" x-model="shouldRemove">
                        </div>
                        @error('image')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700">Nama produk</label>
                        <input id="name" type="text" name="name" value="{{ old('name', $product->name) }}" class="mt-2 block w-full rounded-xl border-slate-300 focus:border-[#E85D40] focus:ring-[#E85D40]">
                        @error('name') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label for="category_id" class="block text-sm font-semibold text-slate-700">Kategori</label>
                            <select id="category_id" name="category_id" class="mt-2 block w-full rounded-xl border-slate-300 focus:border-[#E85D40] focus:ring-[#E85D40]">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="size_id" class="block text-sm font-semibold text-slate-700">Ukuran</label>
                            <select id="size_id" name="size_id" class="mt-2 block w-full rounded-xl border-slate-300 focus:border-[#E85D40] focus:ring-[#E85D40]">
                                <option value="">Pilih ukuran</option>
                                @foreach ($sizes as $size)
                                    <option value="{{ $size->id }}" @selected(old('size_id', $product->size_id) == $size->id)>{{ $size->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label for="brand" class="block text-sm font-semibold text-slate-700">Merek</label>
                            <input id="brand" type="text" name="brand" value="{{ old('brand', $product->brand) }}" class="mt-2 block w-full rounded-xl border-slate-300 focus:border-[#1D4ED8] focus:ring-[#1D4ED8]">
                        </div>
                        <div>
                            <label for="model" class="block text-sm font-semibold text-slate-700">Model</label>
                            <input id="model" type="text" name="model" value="{{ old('model', $product->model) }}" class="mt-2 block w-full rounded-xl border-slate-300 focus:border-[#1D4ED8] focus:ring-[#1D4ED8]">
                        </div>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label for="gender" class="block text-sm font-semibold text-slate-700">Jenis Kelamin</label>
                            <select id="gender" name="gender" class="mt-2 block w-full rounded-xl border-slate-300 focus:border-[#1D4ED8] focus:ring-[#1D4ED8]">
                                <option value="unisex" @selected(old('gender', $product->gender) == 'unisex')>Unisex</option>
                                <option value="pria" @selected(old('gender', $product->gender) == 'pria')>Pria</option>
                                <option value="wanita" @selected(old('gender', $product->gender) == 'wanita')>Wanita</option>
                            </select>
                        </div>
                        <div>
                            <label for="color" class="block text-sm font-semibold text-slate-700">Warna</label>
                            <input id="color" type="text" name="color" value="{{ old('color', $product->color) }}" placeholder="Contoh: Biru Tua, Hitam, Abu-abu" class="mt-2 block w-full rounded-xl border-slate-300 focus:border-[#1D4ED8] focus:ring-[#1D4ED8]">
                        </div>
                    </div>

                    <div class="grid gap-6 md:grid-cols-3">
                        <div>
                            <label for="price" class="block text-sm font-semibold text-slate-700">Harga</label>
                            <input id="price" type="number" name="price" value="{{ old('price', $product->price) }}" class="mt-2 block w-full rounded-xl border-slate-300 focus:border-[#E85D40] focus:ring-[#E85D40]">
                        </div>
                        <div>
                            <label for="stock" class="block text-sm font-semibold text-slate-700">Stok</label>
                            <input id="stock" type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="mt-2 block w-full rounded-xl border-slate-300 focus:border-[#E85D40] focus:ring-[#E85D40]">
                        </div>
                        <div>
                            <label for="min_stock" class="block text-sm font-semibold text-slate-700">Minimum stok</label>
                            <input id="min_stock" type="number" name="min_stock" value="{{ old('min_stock', $product->min_stock) }}" class="mt-2 block w-full rounded-xl border-slate-300 focus:border-[#E85D40] focus:ring-[#E85D40]">
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-semibold text-slate-700">Deskripsi</label>
                        <textarea id="description" name="description" rows="5" class="mt-2 block w-full rounded-xl border-slate-300 focus:border-[#E85D40] focus:ring-[#E85D40]">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">
                        <a href="{{ route('karyawan.products.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                            Kembali
                        </a>
                        <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-[#E85D40] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-600">
                            Update Produk
                        </button>
                    </div>
                </form>
            </div>

            <div class="space-y-6">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-slate-900">Ringkasan produk</h3>
                    <div class="mt-4 space-y-4 text-sm text-slate-600">
                        <div>
                            <p class="font-medium text-slate-900">Slug otomatis</p>
                            <p>Slug akan diperbarui otomatis berdasarkan nama produk dan tetap unik.</p>
                        </div>
                        <div>
                            <p class="font-medium text-slate-900">Status stok saat ini</p>
                            <p>{{ $product->stock }} unit tersedia dengan batas minimum {{ $product->min_stock }} unit.</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-amber-100 bg-amber-50 p-6">
                    <p class="text-sm font-semibold text-amber-900">Perhatian</p>
                    <p class="mt-2 text-sm text-amber-700">Jika stok diubah ke nilai rendah, produk ini akan langsung muncul di panel stok prioritas pada dashboard admin.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function imageUploadEdit(existingUrl, existingName) {
            return {
                preview: existingUrl || null,
                fileName: existingName || '',
                fileSize: '',
                isDragging: false,
                shouldRemove: '0',

                handleFileSelect(event) {
                    const file = event.target.files[0];
                    if (file) this.processFile(file);
                },

                handleDrop(event) {
                    this.isDragging = false;
                    const file = event.dataTransfer.files[0];
                    if (file) {
                        const dt = new DataTransfer();
                        dt.items.add(file);
                        this.$refs.fileInput.files = dt.files;
                        this.processFile(file);
                    }
                },

                processFile(file) {
                    const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
                    if (!validTypes.includes(file.type)) {
                        alert('Format file tidak didukung. Gunakan JPG, PNG, atau WEBP.');
                        return;
                    }
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Ukuran file terlalu besar. Maksimal 2MB.');
                        return;
                    }

                    this.shouldRemove = '0';
                    this.fileName = file.name;
                    this.fileSize = this.formatSize(file.size);

                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.preview = e.target.result;
                    };
                    reader.readAsDataURL(file);
                },

                removeImage() {
                    this.preview = null;
                    this.fileName = '';
                    this.fileSize = '';
                    this.shouldRemove = '1';
                    this.$refs.fileInput.value = '';
                },

                formatSize(bytes) {
                    if (bytes < 1024) return bytes + ' B';
                    if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
                    return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
                }
            };
        }
    </script>
</x-admin-layout>
