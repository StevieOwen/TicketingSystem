<x-adminLayout>

    @php
        $statusStyles = [
            'pending'    => 'bg-amber-100 text-amber-700',
            'accepted'   => 'bg-sky-100 text-sky-700',
            'processing' => 'bg-purple-100 text-purple-700',
            'done'       => 'bg-emerald-100 text-emerald-700',
            'rejected'   => 'bg-rose-100 text-rose-700',
        ];

        $issueStyles = [
            'academic' => 'bg-indigo-50 text-indigo-700',
            'finance'  => 'bg-emerald-50 text-emerald-700',
            'system'   => 'bg-sky-50 text-sky-700',
        ];

        $activeTickets = $tickets->whereIn('status', ['pending', 'accepted', 'processing'])->count();
    @endphp

    <div
        x-data="ticketManagement()"
        x-on:keydown.escape.window="closeModals()"
        class="mx-auto w-full min-w-0 space-y-6"
    >

        {{-- PAGE HEADER --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="min-w-0">
                <h1 class="text-2xl font-bold tracking-tight text-indigo-950">
                    Global Tickets Oversight
                </h1>
                <p class="mt-2 text-sm leading-relaxed text-slate-500">
                    Monitor, track, and manage support tickets across all university departments.
                </p>
            </div>

            <div class="inline-flex w-fit shrink-0 items-center gap-3 rounded-xl border border-sky-100 bg-sky-50 px-4 py-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-sky-100 text-sky-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 5h16a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-3a2 2 0 0 0 0-4V7a2 2 0 0 1 2-2Z"/>
                        <path stroke-linecap="round" stroke-dasharray="2 3" d="M13 5v14"/>
                    </svg>
                </div>
                <div>
                    <p class="text-lg font-extrabold leading-none text-indigo-950">
                        {{ number_format($activeTickets) }}
                    </p>
                    <p class="mt-1 text-[11px] font-semibold text-sky-700">
                        Active Tickets
                    </p>
                </div>
            </div>
        </div>

        {{-- SUMMARY CARDS --}}
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-5 sm:gap-4">
            @foreach ([
                ['label' => 'Pending', 'status' => 'pending'],
                ['label' => 'Accepted', 'status' => 'accepted'],
                ['label' => 'Processing', 'status' => 'processing'],
                ['label' => 'Done', 'status' => 'done'],
                ['label' => 'Rejected', 'status' => 'rejected'],
            ] as $summary)
                <div class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm transition hover:shadow-md">
                    <div class="flex items-center gap-2">
                        <span @class([
                            'h-2 w-2 rounded-full',
                            'bg-amber-500' => $summary['status'] === 'pending',
                            'bg-sky-500' => $summary['status'] === 'accepted',
                            'bg-purple-500' => $summary['status'] === 'processing',
                            'bg-emerald-500' => $summary['status'] === 'done',
                            'bg-rose-500' => $summary['status'] === 'rejected',
                        ])></span>
                        <p class="text-xs font-semibold text-slate-500">
                            {{ $summary['label'] }}
                        </p>
                    </div>
                    <p class="mt-3 font-mono text-2xl font-extrabold text-indigo-950">
                        {{ number_format($tickets->where('status', $summary['status'])->count()) }}
                    </p>
                </div>
            @endforeach
        </div>

        {{-- TICKETS DIRECTORY --}}
        <section class="min-w-0 overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">
            <div class="space-y-5 border-b border-slate-100 px-4 py-5 sm:px-6">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h2 class="text-base font-bold text-indigo-950">All Support Tickets</h2>
                        <p class="mt-1 text-xs text-slate-500">Inspect tickets submitted across all departments.</p>
                    </div>

                    <div class="relative w-full lg:max-w-xs">
                        <input
                            type="search"
                            x-model.debounce.250ms="search"
                            placeholder="Search tickets..."
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-4 pr-4 text-sm text-slate-700 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-500/10"
                        >
                    </div>
                </div>
            </div>

            <div class="w-full overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50/80 text-xs font-semibold uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="px-3 py-4 sm:px-6">Ticket / Subject</th>
                            <th class="hidden px-4 py-4 md:table-cell">Student</th>
                            <th class="hidden px-4 py-4 lg:table-cell">Issue Type</th>
                            <th class="hidden px-4 py-4 xl:table-cell">Assigned Officer</th>
                            <th class="hidden px-4 py-4 sm:table-cell">Status</th>
                            <th class="hidden px-4 py-4 xl:table-cell">Date Generated</th>
                            <th class="px-3 py-4 text-right sm:px-6">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($tickets as $ticket)
                            @php
                                $ticketData = [
                                    'id' => $ticket->id,
                                    'subject' => $ticket->subject,
                                    'description' => $ticket->description,
                                    'issueType' => $ticket->issueType,
                                    'status' => $ticket->status,
                                    'student_name' => $ticket->student?->name ?? 'Unknown Student',
                                    'student_email' => $ticket->student?->email ?? 'Not available',
                                    'officer_id' => $ticket->officer_id,
                                    'officer_name' => $ticket->officer?->name,
                                    'officer_email' => $ticket->officer?->email,
                                    'attachment_url' => $ticket->attachment ? \Illuminate\Support\Facades\Storage::disk('public')->url($ticket->attachment) : null,
                                    'rejection_motive' => $ticket->rejection_motive,
                                    'created_at' => $ticket->created_at?->format('d M Y, h:i A'),
                                    'update_url' => route('admin.tickets_update', $ticket),
                                ];
                                $statusClass = $statusStyles[$ticket->status] ?? 'bg-slate-100 text-slate-600';
                                $issueClass = $issueStyles[$ticket->issueType] ?? 'bg-slate-100 text-slate-600';
                            @endphp

                            <tr x-show="isVisible({{ Js::from($ticketData) }})" class="transition-colors hover:bg-slate-50/70">
                                <td class="px-3 py-4 sm:px-6">
                                    <p class="font-mono text-[11px] font-semibold text-sky-600">#{{ $ticket->id }}</p>
                                    <p class="mt-1 font-semibold text-indigo-950">{{ $ticket->subject }}</p>
                                </td>
                                <td class="hidden px-4 py-4 md:table-cell">
                                    <p class="font-semibold text-slate-700">{{ $ticket->student?->name ?? 'Unknown' }}</p>
                                </td>
                                <td class="hidden px-4 py-4 lg:table-cell">
                                    <span class="inline-flex rounded-lg px-2.5 py-1 text-xs font-semibold capitalize {{ $issueClass }}">{{ $ticket->issueType }}</span>
                                </td>
                                <td class="hidden px-4 py-4 xl:table-cell">
                                    {{ $ticket->officer?->name ?? 'Unassigned' }}
                                </td>
                                <td class="hidden px-4 py-4 sm:table-cell">
                                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold capitalize {{ $statusClass }}">{{ $ticket->status }}</span>
                                </td>
                                <td class="hidden whitespace-nowrap px-4 py-4 text-xs text-slate-500 xl:table-cell">
                                    {{ $ticket->created_at?->format('d M Y') ?? '—' }}
                                </td>
                                <td class="px-3 py-4 text-right sm:px-6">
                                    <button
                                        type="button"
                                        x-on:click="openEdit({{ Js::from($ticketData) }})"
                                        class="rounded-lg p-2 text-indigo-600 hover:bg-indigo-50"
                                    >
                                        Edit
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        {{-- EDIT TICKET MODAL --}}
        <template x-teleport="body">
            <div
                x-cloak
                x-show="showEditModal"
                class="fixed inset-0 z-[110] flex items-center justify-center p-4 bg-indigo-950/60 backdrop-blur-sm"
            >
                <div class="w-full max-w-lg rounded-2xl bg-white shadow-2xl p-6">
                    <h2 class="text-lg font-bold text-indigo-950">Edit Ticket Assignment & Status</h2>

                    <form method="POST" x-bind:action="activeTicket?.update_url || ''">
                        @csrf
                        @method('PUT')

                        <div class="mt-4 space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700">Status</label>
                                <select name="status" x-model="editForm.status" class="w-full rounded-xl border border-slate-200 p-3 text-sm">
                                    <option value="pending">Pending</option>
                                    <option value="accepted">Accepted</option>
                                    <option value="processing">Processing</option>
                                    <option value="done">Done</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700">Assign Officer</label>
                                <select name="officer_id" x-model="editForm.officer_id" class="w-full rounded-xl border border-slate-200 p-3 text-sm">
                                    <option value="">-- Unassigned --</option>
                                    @if(isset($groupedStaff))
                                        @foreach($groupedStaff as $dept => $staffs)
                                            <optgroup label="{{ $dept }}">
                                                @foreach($staffs as $staff)
                                                    <option value="{{ $staff->id }}">{{ $staff->name }} ({{ $staff->role }})</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" x-on:click="closeModals()" class="rounded-xl border px-4 py-2 text-sm">Cancel</button>
                            <button type="submit" class="rounded-xl bg-sky-600 px-4 py-2 text-sm text-white">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('ticketManagement', () => ({
                showEditModal: false,
                activeTicket: null,
                search: '',
                statusFilter: 'all',
                issueFilter: 'all',
                editForm: { status: 'pending', officer_id: '' },

                tickets: @js($tickets->map(fn ($t) => [
                    'id' => $t->id,
                    'subject' => $t->subject,
                    'status' => $t->status,
                    'officer_id' => $t->officer_id,
                    'update_url' => route('admin.tickets_update', $t),
                ])->values()),

                get filteredTickets() {
                    return this.tickets;
                },

                isVisible(ticket) {
                    return true;
                },

                openEdit(ticket) {
                    this.activeTicket = ticket;
                    this.editForm = { status: ticket.status || 'pending', officer_id: ticket.officer_id || '' };
                    this.showEditModal = true;
                },

                closeModals() {
                    this.showEditModal = false;
                    this.activeTicket = null;
                }
            }));
        });
    </script>
</x-adminLayout>