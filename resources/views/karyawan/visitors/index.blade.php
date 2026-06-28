<x-admin-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-slate-900">Log Pengunjung Website</h2>
            <p class="mt-1 text-sm text-slate-500">Pantau siapa saja yang mengunjungi website & produk Anda — tanpa perlu login pelanggan.</p>
        </div>
    </x-slot>

    <div class="space-y-6">
        {{-- Summary Cards --}}
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-[#1D4ED8]">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-slate-500">Total Views</p>
                        <p class="text-2xl font-bold text-slate-900">{{ number_format($totalViews, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-slate-500">Views Hari Ini</p>
                        <p class="text-2xl font-bold text-[#1D4ED8]">{{ number_format($todayViews, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-slate-500">Pengunjung Unik</p>
                        <p class="text-2xl font-bold text-violet-600">{{ number_format($uniqueVisitors, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-slate-500">Produk Dilihat</p>
                        <p class="text-2xl font-bold text-amber-600">{{ $uniqueProducts }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Charts Row --}}
        <div class="grid gap-6 lg:grid-cols-3">
            {{-- Weekly Visitor Chart --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-2">
                <h3 class="text-base font-bold text-slate-900 mb-1">Trafik Pengunjung (7 Hari Terakhir)</h3>
                <p class="text-xs text-slate-500 mb-4">Total views & pengunjung unik per hari</p>
                <div id="weeklyVisitorChart"></div>
            </div>

            {{-- Device & Browser --}}
            <div class="space-y-6">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-base font-bold text-slate-900 mb-4">Perangkat</h3>
                    <div class="space-y-3">
                        @php
                            $totalDevices = array_sum($deviceStats);
                            $deviceColors = ['Desktop' => 'bg-[#1D4ED8]', 'Mobile' => 'bg-emerald-500', 'Tablet' => 'bg-amber-500'];
                            $deviceIcons = [
                                'Desktop' => '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>',
                                'Mobile' => '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>',
                                'Tablet' => '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>',
                            ];
                        @endphp
                        @foreach ($deviceStats as $device => $count)
                            @php $percent = $totalDevices > 0 ? round(($count / $totalDevices) * 100) : 0; @endphp
                            <div>
                                <div class="flex items-center justify-between text-sm mb-1">
                                    <span class="flex items-center gap-2 font-medium text-slate-600">
                                        {!! $deviceIcons[$device] ?? '' !!}
                                        {{ $device }}
                                    </span>
                                    <span class="text-slate-500">{{ $count }} <span class="text-xs">({{ $percent }}%)</span></span>
                                </div>
                                <div class="h-2 w-full rounded-full bg-slate-50">
                                    <div class="h-2 rounded-full {{ $deviceColors[$device] ?? 'bg-slate-400' }} transition-all" style="width: {{ $percent }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-base font-bold text-slate-900 mb-4">Browser</h3>
                    <div class="space-y-2.5">
                        @php $totalBrowsers = array_sum($browserStats); @endphp
                        @foreach ($browserStats as $browser => $count)
                            @php $percent = $totalBrowsers > 0 ? round(($count / $totalBrowsers) * 100) : 0; @endphp
                            <div class="flex items-center justify-between text-sm">
                                <span class="font-medium text-slate-600">{{ $browser }}</span>
                                <div class="flex items-center gap-2">
                                    <div class="h-1.5 w-20 rounded-full bg-slate-50">
                                        <div class="h-1.5 rounded-full bg-[#1D4ED8]" style="width: {{ $percent }}%"></div>
                                    </div>
                                    <span class="text-xs text-slate-500 w-14 text-right">{{ $count }} ({{ $percent }}%)</span>
                                </div>
                            </div>
                        @endforeach
                        @if (empty($browserStats))
                            <p class="text-sm text-slate-500">Belum ada data.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Top Viewed Products --}}
        @if ($topProducts->isNotEmpty())
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-base font-bold text-slate-900 mb-1">Produk Paling Sering Dilihat</h3>
            <p class="text-xs text-slate-500 mb-4">5 produk teratas berdasarkan jumlah views</p>
            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-5">
                @foreach ($topProducts as $i => $pv)
                    <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50/50 p-3">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg {{ $i === 0 ? 'bg-amber-100 text-amber-700' : 'bg-slate-200 text-slate-500' }} text-sm font-bold">
                            #{{ $i + 1 }}
                        </div>
                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold text-slate-900">{{ optional($pv->product)->name ?? 'Produk Dihapus' }}</p>
                            <p class="text-xs text-slate-500">{{ $pv->total_views }} views · {{ $pv->unique_views }} unik</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Filter & Log Table --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Log Aktivitas Terbaru</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Detail kunjungan pengunjung website</p>
                </div>

                {{-- Filter Form --}}
                <form method="GET" action="{{ route('karyawan.visitors.index') }}" class="flex flex-wrap items-end gap-2">
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Dari</label>
                        <input type="date" name="date_from" value="{{ $dateFrom }}" class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:border-[#003B95] focus:ring-[#003B95]">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Sampai</label>
                        <input type="date" name="date_to" value="{{ $dateTo }}" class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:border-[#003B95] focus:ring-[#003B95]">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Tipe</label>
                        <select name="page_type" class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:border-[#003B95] focus:ring-[#003B95]">
                            <option value="all" {{ $pageType === 'all' || !$pageType ? 'selected' : '' }}>Semua</option>
                            <option value="catalog" {{ $pageType === 'catalog' ? 'selected' : '' }}>Katalog</option>
                            <option value="product" {{ $pageType === 'product' ? 'selected' : '' }}>Detail Produk</option>
                        </select>
                    </div>
                    <button type="submit" class="rounded-xl bg-[#1D4ED8] px-4 py-2 text-sm font-medium text-slate-900 shadow-sm transition hover:bg-[#002d73]">
                        Filter
                    </button>
                    @if ($dateFrom || $dateTo || ($pageType && $pageType !== 'all'))
                        <a href="{{ route('karyawan.visitors.index') }}" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-500 transition hover:bg-slate-50">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="pb-3 text-left font-bold text-slate-500 uppercase tracking-wider text-xs">Waktu</th>
                            <th class="pb-3 text-left font-bold text-slate-500 uppercase tracking-wider text-xs">Tipe</th>
                            <th class="pb-3 text-left font-bold text-slate-500 uppercase tracking-wider text-xs">Halaman / Produk</th>
                            <th class="pb-3 text-left font-bold text-slate-500 uppercase tracking-wider text-xs">IP Address</th>
                            <th class="pb-3 text-left font-bold text-slate-500 uppercase tracking-wider text-xs">Perangkat</th>
                            <th class="pb-3 text-left font-bold text-slate-500 uppercase tracking-wider text-xs">Browser</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse ($views as $view)
                            <tr class="group transition hover:bg-slate-50/50">
                                <td class="py-3.5 pr-4 text-slate-500 whitespace-nowrap">
                                    <div class="text-sm">{{ $view->created_at->format('d M Y') }}</div>
                                    <div class="text-xs text-slate-500">{{ $view->created_at->format('H:i:s') }}</div>
                                </td>
                                <td class="py-3.5 pr-4">
                                    @if ($view->page_type === 'catalog')
                                        <span class="inline-flex items-center rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-semibold text-[#1D4ED8]">
                                            Katalog
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-lg bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                            Produk
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 pr-4">
                                    @if ($view->product)
                                        <a href="{{ route('catalog.show', $view->product->slug) }}" class="font-semibold text-slate-900 hover:text-[#1D4ED8] transition" target="_blank">
                                            {{ $view->product->name }}
                                        </a>
                                    @else
                                        <span class="text-slate-500 italic">Halaman Katalog</span>
                                    @endif
                                </td>
                                <td class="py-3.5 pr-4">
                                    <span class="font-mono text-xs text-slate-500 bg-slate-50 px-2 py-1 rounded-lg">{{ $view->ip_address ?? '-' }}</span>
                                </td>
                                <td class="py-3.5 pr-4 text-slate-500">
                                    <span class="inline-flex items-center gap-1 text-xs">
                                        @if ($view->device === 'Mobile')
                                            <svg class="h-3.5 w-3.5 text-emerald-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                                        @elseif ($view->device === 'Tablet')
                                            <svg class="h-3.5 w-3.5 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                                        @else
                                            <svg class="h-3.5 w-3.5 text-[#1D4ED8]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                        @endif
                                        {{ $view->device }}
                                    </span>
                                </td>
                                <td class="py-3.5 pr-4 text-xs text-slate-500">{{ $view->browser }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center">
                                    <svg class="mx-auto h-12 w-12 text-slate-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <p class="mt-3 text-sm text-slate-500">Belum ada aktivitas pengunjung tercatat.</p>
                                    <p class="mt-1 text-xs text-slate-500">Data akan muncul saat pelanggan mengunjungi katalog atau produk Anda.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $views->links() }}
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Weekly Visitor Chart
            var weeklyOptions = {
                series: [{
                    name: 'Total Views',
                    data: {!! json_encode($weeklyData->pluck('total')->values()) !!}
                }, {
                    name: 'Pengunjung Unik',
                    data: {!! json_encode($weeklyData->pluck('unique')->values()) !!}
                }],
                chart: {
                    type: 'area',
                    height: 280,
                    fontFamily: 'Figtree, sans-serif',
                    toolbar: { show: false },
                    sparkline: { enabled: false },
                },
                colors: ['#003B95', '#10b981'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.35,
                        opacityTo: 0.05,
                        stops: [0, 95, 100]
                    }
                },
                stroke: { curve: 'smooth', width: 2.5 },
                grid: {
                    borderColor: '#f1f5f9',
                    padding: { left: 10, right: 10 }
                },
                xaxis: {
                    categories: {!! json_encode($weeklyData->pluck('full_label')->values()) !!},
                    labels: { style: { colors: '#94a3b8', fontSize: '12px' } },
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                },
                yaxis: {
                    labels: {
                        style: { colors: '#94a3b8', fontSize: '12px' },
                        formatter: (val) => Math.round(val)
                    },
                },
                dataLabels: { enabled: false },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    fontSize: '12px',
                    fontWeight: 600,
                    markers: { radius: 4 }
                },
                tooltip: {
                    theme: 'dark',
                    y: { formatter: (val) => val + ' kunjungan' }
                }
            };

            var weeklyChart = new ApexCharts(document.querySelector("#weeklyVisitorChart"), weeklyOptions);
            weeklyChart.render();
        });
    </script>
    @endpush
</x-admin-layout>
