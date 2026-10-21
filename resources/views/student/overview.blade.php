<x-studentLayout>

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

        $totalGenerated =$mySubmittedTickets->count();
        $totalAccepted =$mySubmittedTickets->where('status', 'accepted')->count();
        $totalRejected =$mySubmittedTickets->where('status', 'rejected')->count();
        $totalDone =$mySubmittedTickets->where('status', 'done')->count();
    @endphp

    <div
        x-data="studentTickets()"
        x-on:keydown.escape.window="closeModals()"
        class="mx-auto w-full min-w-0 space-y-6"
    >

        {{-- PAGE HEADER & CREATE BUTTON --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-indigo-950">
                    My Support Tickets
                </h1>
                <p class="mt-1 text-sm text-slate-500">
                    Track the status of your submitted issues or create a new request.
                </p>
            </div>

            <button
                type="button"
                x-on:click="openCreateModal()"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Raise New Ticket
            </button>
        </div>


        {{-- SUCCESS / ERROR NOTIFICATIONS --}}
        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
                <p class="font-semibold">Please fix the following errors:</p>
                <ul class="mt-1 list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        {{-- SUMMARY CARDS --}}
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-4 sm:gap-4">
            <div class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm">
                <p class="text-xs font-semibold text-slate-500">Total Generated</p>
                <p class="mt-2 font-mono text-2xl font-extrabold text-indigo-950">{{ number_format($totalGenerated) }}</p>
            </div>
            <div class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm">
                <p class="text-xs font-semibold text-slate-500">Total Accepted</p>
                <p class="mt-2 font-mono text-2xl font-extrabold text-sky-600">{{ number_format($totalAccepted) }}</p>
            </div>
            <div class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm">
                <p class="text-xs font-semibold text-slate-500">Total Done</p>
                <p class="mt-2 font-mono text-2xl font-extrabold text-emerald-600">{{ number_format($totalDone) }}</p>
            </div>
            <div class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm">
                <p class="text-xs font-semibold text-slate-500">Total Rejected</p>
                <p class="mt-2 font-mono text-2xl font-extrabold text-rose-600">{{ number_format($totalRejected) }}</p>
            </div>
        </div>


        {{-- TICKETS DIRECTORY TABLE --}}
        <section class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-6 py-4">
                <h2 class="text-base font-bold text-indigo-950">Ticket History</h2>
            </div>

            <div class="w-full overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50/80 text-xs font-semibold uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="px-6 py-4">Subject</th>
                            <th class="px-4 py-4">Issue Type</th>
                            <th class="px-4 py-4">Assigned Officer</th>
                            <th class="px-4 py-4">Status & Notes</th>
                            <th class="px-4 py-4">Date Generated</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if ($mySubmittedTickets->isEmpty()): ?>
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-sm text-slate-400">
                                    No tickets found. Click "Raise New Ticket" to get started.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($mySubmittedTickets as$ticket): ?>
                                <?php
                                    $statusClass = $statusStyles[$ticket->status] ?? 'bg-slate-100 text-slate-600';
                                    $issueClass =$issueStyles[$ticket->issueType] ?? 'bg-slate-100 text-slate-600';$ticketData = [
                                        'id' => $ticket->id,
                                        'subject' => $ticket->subject,
                                        'description' => $ticket->description,
                                        'issueType' => $ticket->issueType,
                                        'status' => $ticket->status,
                                        'rejection_motive' => $ticket->rejection_motive,
                                        'update_url' => route('students.tickets_update', $ticket),
                                    ];
                                ?>

                                <tr class="transition-colors hover:bg-slate-50/70">
                                    <td class="px-6 py-4">
                                        <p class="font-mono text-[11px] font-semibold text-sky-600">#{{ $ticket->id }}</p>
                                        <p class="mt-1 font-semibold text-indigo-950">{{ $ticket->subject }}</p>
                                    </td>

                                    <td class="px-4 py-4">
                                        <span class="inline-flex rounded-lg px-2.5 py-1 text-xs font-semibold capitalize {{ $issueClass }}">
                                            {{ $ticket->issueType }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-4 text-slate-600">
                                        {{ $ticket->officer?->name ?? 'Unassigned' }}
                                    </td>

                                    <td class="px-4 py-4">
                                        <div class="space-y-1">
                                            <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold capitalize {{ $statusClass }}">
                                                <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                                {{ $ticket->status }}
                                            </span>
                                            @if ($ticket->status === 'rejected' &&$ticket->rejection_motive)
                                                <p class="text-xs text-rose-600 font-medium max-w-xs">
                                                    <span class="font-bold">Reason:</span> {{ $ticket->rejection_motive }}
                                                </p>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="whitespace-nowrap px-4 py-4 text-xs text-slate-500">
                                        {{ $ticket->created_at?->format('d M Y, h:i A') }}
                                    </td>

                                    <td class="px-6 py-4 text-right">
                                        @if ($ticket->status === 'rejected')
                                            <button
                                                type="button"
                                                x-on:click="openEditModal({{ Js::from($ticketData) }})"
                                                class="inline-flex items-center gap-1 rounded-xl bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-600 transition hover:bg-indigo-100"
                                            >
                                                Edit & Resubmit
                                            </button>
                                        @else
                                            <span class="text-xs text-slate-400">—</span>
                                        @endif
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>


        {{-- =====================================================
             CREATE TICKET MODAL
        ====================================================== --}}
        <template x-teleport="body">
            <div
                x-cloak
                x-show="showCreateModal"
                x-transition.opacity
                class="fixed inset-0 z-[110] flex items-center justify-center p-4 bg-indigo-950/60 backdrop-blur-sm"
            >
                <div class="w-full max-w-lg rounded-2xl bg-white shadow-2xl p-6">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                        <h2 class="text-lg font-bold text-indigo-950">Raise New Support Ticket</h2>
                        <button type="button" x-on:click="closeModals()" class="text-slate-400 hover:text-slate-700">✕</button>
                    </div>

                    <form action="{{ route('students.tickets_create') }}" method="POST" enctype="multipart/form-data" class="mt-4 space-y-4">
                        @csrf

                        <div>
                            <label class="block text-sm font-semibold text-slate-700">Subject</label>
                            <input type="text" name="subject" required class="mt-1 w-full rounded-xl border border-slate-200 p-3 text-sm focus:border-sky-500 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700">Issue Type</label>
                            <select name="issueType" required class="mt-1 w-full rounded-xl border border-slate-200 p-3 text-sm focus:border-sky-500 focus:outline-none">
                                <option value="academic">Academic</option>
                                <option value="finance">Finance</option>
                                <option value="system">System</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700">Description</label>
                            <textarea name="description" rows="3" required class="mt-1 w-full rounded-xl border border-slate-200 p-3 text-sm focus:border-sky-500 focus:outline-none"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700">Attachment (Image max 5MB)</label>
                            <input type="file" name="attachment" accept="image/*" required class="mt-1 w-full text-sm text-slate-500 file:mr-4 file:rounded-xl file:border-0 file:bg-sky-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-sky-700 hover:file:bg-sky-100">
                        </div>

                        <div class="flex justify-end gap-3 pt-2">
                            <button type="button" x-on:click="closeModals()" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600">Cancel</button>
                            <button type="submit" class="rounded-xl bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-700">Submit Ticket</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>


        {{-- =====================================================
             EDIT TICKET MODAL (For Rejected Tickets)
        ====================================================== --}}
        <template x-teleport="body">
            <div
                x-cloak
                x-show="showEditModal"
                x-transition.opacity
                class="fixed inset-0 z-[110] flex items-center justify-center p-4 bg-indigo-950/60 backdrop-blur-sm"
            >
                <div class="w-full max-w-lg rounded-2xl bg-white shadow-2xl p-6">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                        <div>
                            <h2 class="text-lg font-bold text-indigo-950">Edit & Resubmit Ticket</h2>
                            <p class="text-xs font-mono text-sky-600" x-text="activeTicket ? `Ticket #${activeTicket.id}` : ''"></p>
                        </div>
                        <button type="button" x-on:click="closeModals()" class="text-slate-400 hover:text-slate-700">✕</button>
                    </div>

                    <form method="POST" x-bind:action="activeTicket?.update_url || ''" enctype="multipart/form-data" class="mt-4 space-y-4">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="block text-sm font-semibold text-slate-700">Subject</label>
                            <input type="text" name="subject" x-model="editForm.subject" required class="mt-1 w-full rounded-xl border border-slate-200 p-3 text-sm focus:border-sky-500 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700">Description</label>
                            <textarea name="description" x-model="editForm.description" rows="3" required class="mt-1 w-full rounded-xl border border-slate-200 p-3 text-sm focus:border-sky-500 focus:outline-none"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700">New Attachment (Required for update)</label>
                            <input type="file" name="attachment" accept="image/*" required class="mt-1 w-full text-sm text-slate-500 file:mr-4 file:rounded-xl file:border-0 file:bg-sky-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-sky-700 hover:file:bg-sky-100">
                        </div>

                        <div class="flex justify-end gap-3 pt-2">
                            <button type="button" x-on:click="closeModals()" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600">Cancel</button>
                            <button type="submit" class="rounded-xl bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-700">Resubmit Ticket</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('studentTickets', () => ({
                showCreateModal: false,
                showEditModal: false,
                activeTicket: null,
                editForm: { subject: '', description: '' },

                openCreateModal() {
                    this.closeModals();
                    this.showCreateModal = true;
                },

                openEditModal(ticket) {
                    this.closeModals();
                    this.activeTicket = ticket;
                    this.editForm = {
                        subject: ticket.subject || '',
                        description: ticket.description || ''
                    };
                    this.showEditModal = true;
                },

                closeModals() {
                    this.showCreateModal = false;
                    this.showEditModal = false;
                    this.activeTicket = null;
                }
            }));
        });
    </script>
</x-studentLayout>