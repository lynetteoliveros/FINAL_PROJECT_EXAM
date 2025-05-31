<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data :class="{ 'dark': $store.darkMode.on }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Font Display -->
        <style>
            /* Ensure fonts load with swap to prevent FOUT */
            @font-face {
                font-family: 'Figtree';
                font-display: swap;
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script>
            // Dark mode store
            document.addEventListener('alpine:init', () => {
                Alpine.store('darkMode', {
                    on: localStorage.getItem('darkMode') === 'true',
                    toggle() {
                        this.on = !this.on;
                        localStorage.setItem('darkMode', this.on);
                    }
                });
            });

            // Existing notifications store
            document.addEventListener('alpine:init', () => {
                Alpine.store('notifications', {
                    show: false,
                    count: 0,
                    items: [],
                    async init() {
                        await this.fetchNotifications();
                        // Poll for new notifications every 30 seconds
                        setInterval(() => this.fetchNotifications(), 30000);
                    },
                    async fetchNotifications() {
                        try {
                            const response = await fetch('/notifications');
                            const data = await response.json();
                            this.items = data.notifications;
                            this.count = data.unread_count;
                        } catch (error) {
                            console.error('Failed to fetch notifications:', error);
                        }
                    },
                    async markAsRead(id) {
                        try {
                            await fetch(`/notifications/${id}/read`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                }
                            });
                            await this.fetchNotifications();
                        } catch (error) {
                            console.error('Failed to mark notification as read:', error);
                        }
                    }
                });
            });
        </script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-dark-bg-primary">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-dark-bg-secondary shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Notifications -->
            <x-notification />

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
