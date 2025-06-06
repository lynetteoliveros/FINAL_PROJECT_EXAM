<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-dark-bg-secondary overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('Appearance') }}
                    </h3>
                    
                    <div class="mt-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">Dark Mode</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Toggle dark mode on or off</p>
                            </div>
                            <button 
                                type="button" 
                                @click="$store.darkMode.toggle()"
                                :class="$store.darkMode.on ? 'bg-indigo-600' : 'bg-gray-200'"
                                class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2"
                                role="switch"
                                :aria-checked="$store.darkMode.on"
                            >
                                <span 
                                    :class="$store.darkMode.on ? 'translate-x-5' : 'translate-x-0'"
                                    class="pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                >
                                    <span
                                        :class="$store.darkMode.on ? 'opacity-0 duration-100 ease-out' : 'opacity-100 duration-200 ease-in'"
                                        class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity"
                                    >
                                        <svg class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 12 12">
                                            <path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                    <span
                                        :class="$store.darkMode.on ? 'opacity-100 duration-200 ease-in' : 'opacity-0 duration-100 ease-out'"
                                        class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity"
                                    >
                                        <svg class="h-3 w-3 text-indigo-600" fill="currentColor" viewBox="0 0 12 12">
                                            <path d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z" />
                                        </svg>
                                    </span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 