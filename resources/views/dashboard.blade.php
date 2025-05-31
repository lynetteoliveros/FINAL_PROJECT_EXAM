<x-app-layout>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <!-- Total Tickets -->
                <div class="bg-white dark:bg-dark-bg-secondary overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-900 dark:text-gray-100 text-xl font-semibold mb-2">Total Tickets</div>
                        <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $statistics['total'] }}</div>
                    </div>
                </div>

                <!-- Unassigned Tickets -->
                <div class="bg-white dark:bg-dark-bg-secondary overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-900 dark:text-gray-100 text-xl font-semibold mb-2">Unassigned</div>
                        <div class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">{{ $statistics['unassigned'] }}</div>
                    </div>
                </div>

                <!-- My Tickets -->
                <div class="bg-white dark:bg-dark-bg-secondary overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-900 dark:text-gray-100 text-xl font-semibold mb-2">My Tickets</div>
                        <div class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $statistics['my_tickets'] }}</div>
                    </div>
                </div>
            </div>

            <!-- Status and Severity Breakdown -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Status Breakdown -->
                <div class="bg-white dark:bg-dark-bg-secondary overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-900 dark:text-gray-100 text-xl font-semibold mb-4">By Status</div>
                        <div class="space-y-4">
                            @foreach(App\Enums\TicketStatus::cases() as $status)
                                <div class="flex justify-between items-center">
                                    <div class="text-gray-600 dark:text-gray-400">{{ $status->label() }}</div>
                                    <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                        {{ $statistics['by_status'][$status->value] ?? 0 }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Severity Breakdown -->
                <div class="bg-white dark:bg-dark-bg-secondary overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-900 dark:text-gray-100 text-xl font-semibold mb-4">By Severity</div>
                        <div class="space-y-4">
                            @foreach(App\Enums\TicketSeverity::cases() as $severity)
                                <div class="flex justify-between items-center">
                                    <div class="text-gray-600 dark:text-gray-400">{{ $severity->label() }}</div>
                                    <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                        {{ $statistics['by_severity'][$severity->value] ?? 0 }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>