 @if (Auth::check())
     <div class="mt-6 flex items-center justify-center gap-2 text-sm text-neutral-500 flex-wrap">
         <div class="text-center">
             <span>Authenticated as</span>
             <x-ui.tooltip text="{{ Auth::user()->email }}" position="top">
                 <span class="font-bold">{{ Auth::user()->name }}</span>
             </x-ui.tooltip>
         </div>
         <span class="text-neutral-300 hidden sm:inline">•</span>
         <form
             method="POST"
             action="{{ route('logout') }}"
             class="inline"
         >
             @csrf
             <button type="submit"
                 class="text-neutral-500 hover:text-red-600 transition-colors duration-200 underline decoration-dotted underline-offset-2"
             >
                 Logout
             </button>
         </form>
     </div>
 @endif
