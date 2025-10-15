<x-ui.card>
    <div
        class="h-36"
        x-data="{
            loading: false,
            selectedDate: '{{ now()->toDateString() }}',
            includeMerges: false,
            formatDateForUrl(dateString) {
                if (!dateString) return '{{ now()->toDateString() }}';
                // Convert from 'MMM DD, YYYY' to 'YYYY-MM-DD'
                const date = new Date(dateString);
                if (isNaN(date.getTime())) return '{{ now()->toDateString() }}';
                return date.getFullYear() + '-' +
                    String(date.getMonth() + 1).padStart(2, '0') + '-' +
                    String(date.getDate()).padStart(2, '0');
            },
            buildUrl(baseUrl) {
                const separator = baseUrl.includes('?') ? '&' : '?';
                return baseUrl + (this.includeMerges ? separator + 'include_merges=1' : '');
            },
            navigateToCommits(url) {
                this.loading = true;
                window.location.href = this.buildUrl(url);
            }
        }"
        x-on:date-selected.window="selectedDate = formatDateForUrl($event.detail.date)"
    >
        <div class="fixed top-0 right-0 bg-white p-4">
            <x-ui.switch
                name="includeMerges"
                label="Include merge commits"
                label-position="left"
            />
        </div>


        @if (Auth::check())
            <!-- Loading State -->
            <div
                x-show="loading"
                class="h-full flex flex-col items-center justify-center"
                x-cloak
            >
                <span class="loader"></span>
                <p class="text-sm text-neutral-500">Fetching your commits...</p>
            </div>

            <!-- Normal State -->
            <div x-show="!loading" class="max-w-lg h-full flex flex-col justify-between">
                <div class="grid grid-cols-2 gap-2">
                    <x-ui.button
                        severity="secondary"
                        type="button"
                        x-on:click="navigateToCommits('{{ route('commits', ['date' => now()->subDay()->toDateString()]) }}')"
                    >
                        Yesterday
                    </x-ui.button>
                    <x-ui.button
                        severity="primary"
                        type="button"
                        x-on:click="navigateToCommits('{{ route('commits', ['date' => now()->toDateString()]) }}')"
                    >
                        Today
                    </x-ui.button>
                </div>

                <div
                    class="py-4 flex items-center text-sm text-gray-500 before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6">
                    Or choose a date
                </div>

                <div class="flex gap-2">
                    <div class="grow">
                        <x-ui.date-picker />
                    </div>
                    <x-ui.button
                        severity="secondary"
                        type="button"
                        x-on:click="navigateToCommits('{{ route('commits') }}?date=' + selectedDate)"
                    >
                        Search
                    </x-ui.button>
                </div>
            </div>
        @else
            <div class="h-full flex flex-col items-center justify-center gap-4">
                <div>To view your commits, please sign in.</div>
                <x-ui.button
                    severity="primary"
                    type="link"
                    href="{{ route('auth.redirect') }}"
                >
                    Sign in with GitHub
                </x-ui.button>
            </div>
        @endif
    </div>
</x-ui.card>
