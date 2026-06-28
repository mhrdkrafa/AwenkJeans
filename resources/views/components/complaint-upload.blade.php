@php
    $isRequired = $required ?? false;
@endphp

<div x-data="{ files: [], dragOver: false, showError: false }" @show-attachment-error.window="showError = true" class="mt-4">
    <label class="block text-sm font-medium text-slate-600 mb-1">
        <svg class="inline w-4 h-4 mr-1 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
        </svg>
        Bukti Lampiran @if($isRequired)<span class="text-rose-500">*</span>@else<span class="text-slate-400 font-normal text-xs">(Opsional)</span>@endif
    </label>
    <p class="text-xs text-slate-400 mb-2">
        @if($isRequired)
            Wajib upload gambar/video sebagai bukti. Format: JPG, PNG, GIF, WebP, MP4, MOV, AVI. Maks 20MB per file.
        @else
            Format: JPG, PNG, GIF, WebP, MP4, MOV, AVI. Maks 20MB per file.
        @endif
    </p>

    <div
        class="relative rounded-xl border-2 border-dashed px-4 py-5 text-center transition-all cursor-pointer"
        :class="dragOver ? 'border-[#1D4ED8] bg-blue-50' : 'border-slate-200 hover:border-slate-300 bg-slate-50'"
        @dragover.prevent="dragOver = true"
        @dragleave.prevent="dragOver = false"
        @drop.prevent="
            dragOver = false;
            const dt = $event.dataTransfer;
            const input = $refs.fileInput;
            const dataTransfer = new DataTransfer();
            for (const f of input.files) dataTransfer.items.add(f);
            for (const f of dt.files) dataTransfer.items.add(f);
            input.files = dataTransfer.files;
            files = Array.from(input.files);
        "
        @click="$refs.fileInput.click()"
    >
        <svg class="mx-auto h-8 w-8 text-slate-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
        </svg>
        <p class="text-sm text-slate-500">
            <span class="font-semibold text-[#1D4ED8]">Klik untuk upload</span> atau seret file ke sini
        </p>
        <input
            type="file"
            name="attachments[]"
            multiple
            accept="image/jpeg,image/png,image/gif,image/webp,video/mp4,video/quicktime,video/x-msvideo"
            class="hidden"
            x-ref="fileInput"
            @change="files = Array.from($event.target.files); showError = false"
        >
    </div>

    <!-- File preview list -->
    <template x-if="files.length > 0">
        <div class="mt-3 space-y-2">
            <template x-for="(file, index) in files" :key="index">
                <div class="flex items-center gap-3 rounded-lg bg-slate-50 border border-slate-200 px-3 py-2 text-sm">
                    <template x-if="file.type.startsWith('image/')">
                        <img :src="URL.createObjectURL(file)" class="h-10 w-10 rounded object-cover border border-slate-200" />
                    </template>
                    <template x-if="file.type.startsWith('video/')">
                        <div class="flex h-10 w-10 items-center justify-center rounded bg-slate-200 border border-slate-300">
                            <svg class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </template>
                    <div class="flex-1 min-w-0">
                        <p class="truncate font-medium text-slate-700" x-text="file.name"></p>
                        <p class="text-xs text-slate-400" x-text="(file.size / 1024 / 1024).toFixed(2) + ' MB'"></p>
                    </div>
                    <button type="button" @click.stop="
                        files.splice(index, 1);
                        const dt = new DataTransfer();
                        files.forEach(f => dt.items.add(f));
                        $refs.fileInput.files = dt.files;
                    " class="text-slate-400 hover:text-rose-500 transition">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </template>
        </div>
    </template>

    <!-- Validation error message -->
    <p x-show="showError" x-cloak class="mt-2 text-xs text-rose-600 font-medium flex items-center gap-1">
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" /></svg>
        Wajib upload gambar/video sebagai bukti komplain.
    </p>
</div>
