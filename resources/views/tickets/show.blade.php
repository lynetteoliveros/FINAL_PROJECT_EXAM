<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ticket #{{ $ticket->id }}: {{ $ticket->title }}
            </h2>
            <div class="flex space-x-4">
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('tickets.edit', $ticket) }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Edit Ticket
                    </a>
                @elseif(auth()->user()->isSupervisor() && auth()->user()->department_id === $ticket->department_id)
                    <a href="{{ route('tickets.edit', $ticket) }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Edit Ticket
                    </a>
                @elseif(auth()->user()->isJuniorOfficer() || auth()->user()->isOfficer())
                    @if (
                        $ticket->assigned_to === auth()->id() ||
                            (auth()->user()->department_id === $ticket->department_id &&
                                $ticket->severity === \App\Enums\TicketSeverity::LOW))
                        <a href="{{ route('tickets.edit', $ticket) }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Edit Ticket
                        </a>
                    @endif
                @endif
                <a href="{{ route('tickets.index') }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Ticket Details -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Details</h3>
                            <dl class="space-y-2">
                                <div>
                                    <dt class="font-medium">Status</dt>
                                    <dd>
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ $ticket->status->label() }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="font-medium">Severity</dt>
                                    <dd>
                                        <span class="{{ $ticket->severity->color() }}">
                                            {{ $ticket->severity->label() }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="font-medium">Department</dt>
                                    <dd>{{ $ticket->department->name }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium">Created By</dt>
                                    <dd>{{ $ticket->creator->name }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium">Assigned To</dt>
                                    <dd>{{ $ticket->assignedTo?->name ?? 'Unassigned' }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium">Created At</dt>
                                    <dd>{{ $ticket->created_at->format('M d, Y H:i') }}</dd>
                                </div>
                            </dl>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Description</h3>
                            <p class="whitespace-pre-wrap">{{ $ticket->description }}</p>
                        </div>
                    </div>

                    <!-- Remarks Section -->
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4">Remarks</h3>

                        <!-- Add Remark Form -->
                        <form method="POST" action="{{ route('tickets.remarks.store', $ticket) }}" class="mb-6">
                            @csrf
                            <div>
                                <textarea name="content" rows="3" required
                                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    placeholder="Add a remark..."></textarea>
                                <x-input-error :messages="$errors->get('content')" class="mt-2" />
                            </div>
                            <div class="mt-2">
                                <x-primary-button>Add Remark</x-primary-button>
                            </div>
                        </form>

                        <!-- Remarks List -->
                        <div class="space-y-4">
                            @foreach ($ticket->remarks()->latest()->get() as $remark)
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex justify-between items-start">
                                        <div class="flex items-center">
                                            <span class="font-medium">{{ $remark->user->name }}</span>
                                            <span class="mx-2 text-gray-500">&bull;</span>
                                            <span
                                                class="text-gray-500">{{ $remark->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <p class="mt-2 text-gray-700">{{ $remark->content }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
