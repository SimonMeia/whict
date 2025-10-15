<x-layout>
    <main
        class="relative z-10 px-4 py-12"
        x-data
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
            <!-- Header -->
            <div class="text-center mb-10">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">
                    Commits for {{ \Carbon\Carbon::parse($date)->format('F j, Y') }}
                </h1>
                <p class="text-neutral-500">Your GitHub activity for the selected day</p>

                <!-- Navigation -->
                <div class="mt-6">
                    <x-ui.button
                        severity="secondary"
                        type="link"
                        href="{{ route('home') }}"
                    >
                        ← Back to Home
                    </x-ui.button>
                </div>
            </div>

            @if (count($commits) > 0)
                <!-- Statistics Card -->
                <x-commits.statistics :statistics="$statistics" />

                <!-- Commits List -->
                <div class="space-y-4 mt-8">
                    @foreach ($commits as $commit)
                        <x-commits.commit-card :commit="$commit" />
                    @endforeach
                </div>
            @else
                <!-- No Commits -->
                <x-commits.no-commit-card />
            @endif
        </div>
    </main>
</x-layout>
