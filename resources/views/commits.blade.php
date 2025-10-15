<x-layout>
    <main
        class="relative z-10 px-4 py-12"
        x-data="{ viewMode: 'card' }"
        x-init="setTimeout(() => {
            toast('Commits loaded successfully', {
                type: 'success',
                description: 'Found {{ count($commits) }} commit(s) for this date',
                position: 'top-right'
            });
        }, 500);"
    >
        <!-- Toast Notifications -->
        <x-ui.toast />

        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between mb-4">
                <x-ui.button
                    severity="secondary"
                    type="link"
                    href="{{ route('home') }}"
                >
                    ← Back to Home
                </x-ui.button>

                <div class="inline-flex rounded-lg border border-gray-200 bg-white p-1" role="group">
                    <button
                        x-on:click="viewMode = 'card'"
                        :class="{ 'bg-gray-100 text-gray-900': viewMode === 'card', 'text-gray-600 hover:text-gray-900': viewMode !== 'card' }"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md transition-colors"
                        type="button"
                    >
                        <svg
                            class="w-4 h-4 mr-2"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"
                            ></path>
                        </svg>
                        Cards
                    </button>
                    <button
                        x-on:click="viewMode = 'list'"
                        :class="{ 'bg-gray-100 text-gray-900': viewMode === 'list', 'text-gray-600 hover:text-gray-900': viewMode !== 'list' }"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md transition-colors"
                        type="button"
                    >
                        <svg
                            class="w-4 h-4 mr-2"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            ></path>
                        </svg>
                        List
                    </button>
                </div>
            </div>

            <!-- Header -->
            <div class="text-center my-16">
                <p class="text-neutral-500 text-lg">Commits for </p>
                <h1 class="text-4xl font-bold text-gray-900 mb-4">
                    {{ \Carbon\Carbon::parse($date)->format('F j, Y') }}
                </h1>
            </div>

            @if (count($commits) > 0)
                <!-- Statistics Card -->
                <x-commits.statistics :statistics="$statistics" />

                <!-- Commits Card View -->
                <div x-show="viewMode === 'card'" class="space-y-4">
                    @foreach ($commits as $commit)
                        <x-commits.commit-card :commit="$commit" />
                    @endforeach
                </div>

                <!-- Commits List View -->
                <x-ui.card x-show="viewMode === 'list'">
                    @foreach ($commits as $commit)
                        <x-commits.commit-list-item :commit="$commit" />
                    @endforeach
                </x-ui.card>
            @else
                <!-- No Commits -->
                <x-commits.no-commit-card :date="$date" />
            @endif
        </div>
    </main>
</x-layout>
