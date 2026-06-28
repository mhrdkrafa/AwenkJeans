{{-- Reusable attachment display partial --}}
{{-- Usage: @include('components.complaint-attachments', ['attachments' => $attachments]) --}}

@if(!empty($attachments) && is_array($attachments))
    <div class="mt-3 flex flex-wrap gap-2">
        @foreach($attachments as $attachment)
            @php
                $ext = strtolower(pathinfo($attachment, PATHINFO_EXTENSION));
                $isVideo = in_array($ext, ['mp4', 'mov', 'avi']);
                $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
            @endphp

            @if($isImage)
                <a href="{{ asset('storage/' . $attachment) }}" target="_blank" class="group relative block rounded-lg overflow-hidden border border-slate-200 shadow-sm hover:shadow-md transition">
                    <img src="{{ asset('storage/' . $attachment) }}" alt="Lampiran" class="h-24 w-24 object-cover transition group-hover:scale-105">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition flex items-center justify-center">
                        <svg class="w-5 h-5 text-white opacity-0 group-hover:opacity-100 transition drop-shadow-lg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                        </svg>
                    </div>
                </a>
            @elseif($isVideo)
                <div class="rounded-lg overflow-hidden border border-slate-200 shadow-sm">
                    <video controls class="h-36 max-w-xs rounded-lg" preload="metadata">
                        <source src="{{ asset('storage/' . $attachment) }}" type="video/{{ $ext === 'mov' ? 'quicktime' : $ext }}">
                        Browser Anda tidak mendukung video.
                    </video>
                </div>
            @endif
        @endforeach
    </div>
@endif
