<x-layout>
    <main class="relative z-10 flex w-full h-full flex-col items-center justify-center px-4">
        <x-home.page-title />

        <div class="max-w-md w-full">
            <x-home.form-card />
        </div>

        <x-home.github-user />
    </main>

    <footer class="px-4 py-6 text-center text-sm text-gray-500 absolute bottom-0 w-full z-20">
        &copy; {{ date('Y') }} Whict. Created by
        <a
            href="https://github.com/SimonMeia"
            target="_blank"
            class="text-gray-600 hover:text-gray-800 transition-colors font-medium"
        >
            Simon
        </a>.
    </footer>
</x-layout>
