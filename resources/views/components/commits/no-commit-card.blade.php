<x-ui.card>
    <div class="text-center py-12">
        <svg
            class="mx-auto h-12 w-12 text-gray-400"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
            />
        </svg>
        <h3 class="mt-4 text-lg font-medium text-gray-900">No commits found</h3>
        <p class="mt-2 text-sm text-gray-500">
            No commits were found for {{ \Carbon\Carbon::parse($date)->format('F j, Y') }}.
        </p>
        <div class="mt-6">
            <x-ui.button
                severity="primary"
                type="link"
                href="{{ route('home') }}"
            >
                Choose Another Date
            </x-ui.button>
        </div>
    </div>
</x-ui.card>
