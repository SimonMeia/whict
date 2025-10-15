@props(['commit'])

<div class="border-b border-gray-200 last:border-0 py-4 first:pt-0 last:pb-0">
    <div class="flex items-center justify-between gap-4">
        <!-- Left: Time -->
        <div class="flex-shrink-0 w-12">
            <span class="text-sm font-medium text-gray-900">
                {{ $commit['date_formatted'] }}
            </span>
        </div>

        <!-- Center: Main Content -->
        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-3 mb-1">
                <!-- Repository -->
                <a
                    href="{{ $commit['repository']['url'] }}"
                    target="_blank"
                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 transition-colors"
                >
                    <svg
                        class="w-3.5 h-3.5 mr-1 flex-shrink-0"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M10 0C4.477 0 0 4.484 0 10.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0110 4.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.942.359.31.678.921.678 1.856 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0020 10.017C20 4.484 15.522 0 10 0z"
                            clip-rule="evenodd"
                        ></path>
                    </svg>
                    {{ $commit['repository']['name'] }}
                </a>

                @if ($commit['repository']['language'])
                    <span class="text-xs text-gray-500 hidden sm:inline-flex">
                        {{ $commit['repository']['language'] }}
                    </span>
                @endif

                @if ($commit['verified'])
                    <span
                        class=" items-center px-1.5 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 hidden sm:inline-flex"
                    >
                        <svg
                            class="w-3 h-3 mr-1"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"
                            ></path>
                        </svg>
                        Verified
                    </span>
                @endif
            </div>

            <!-- Commit Message -->
            <p class="text text-gray-900 truncate mb-1">
                {{ $commit['message'] }}
            </p>
        </div>

        <!-- Right: Actions -->
        <div class="flex items-center gap-3 flex-shrink-0">
            <span class="text-xs text-gray-400 font-mono">{{ $commit['short_id'] }}</span>
            <a
                href="{{ $commit['url'] }}"
                target="_blank"
                class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 transition-colors"
            >
                <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"
                    ></path>
                </svg>
            </a>
        </div>
    </div>
</div>
