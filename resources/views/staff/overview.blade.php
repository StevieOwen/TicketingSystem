<x-staffLayout title="My Tickets">

    @php
        /*
        |--------------------------------------------------------------------------
        | Ticket Statistics
        |--------------------------------------------------------------------------
        */

        $totalAssigned =$myAssignedTickets->count();

        $pendingCount =$myAssignedTickets
            ->where('status', 'pending')
            ->count();

        $processingCount =$myAssignedTickets
            ->where('status', 'processing')
            ->count();

        $doneCount =$myAssignedTickets
            ->where('status', 'done')
            ->count();

        $rejectedCount =$myAssignedTickets
            ->where('status', 'rejected')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Badge Classes
        |--------------------------------------------------------------------------
        */

        $statusStyles = [
            'pending' => 'bg-amber-100 text-amber-700',
            'accepted' => 'bg-sky-100 text-sky-700',
            'processing' => 'bg-purple-100 text-purple-700',
            'done' => 'bg-emerald-100 text-emerald-700',
            'rejected' => 'bg-rose-100 text-rose-700',
        ];

        $issueStyles = [
            'academic' => 'bg-indigo-50 text-indigo-700',
            'finance' => 'bg-emerald-50 text-emerald-700',
            'system' => 'bg-sky-50 text-sky-700',
        ];


        /*
        |--------------------------------------------------------------------------
        | Alpine Records
        |--------------------------------------------------------------------------
        | Laravel generates each update URL using route model binding.
        | This also supports UUID ticket identifiers.
        */

        $ticketRecords = $myAssignedTickets->map(function ($ticket) {

            return [
                'id' => $ticket->id,
                'subject' => $ticket->subject,
                'description' => $ticket->description,
                'issueType' => $ticket->issueType,
                'status' => $ticket->status,
                'rejection_motive' => $ticket->rejection_motive,

                'student_name' => $ticket->student?->name ?? 'Unknown Student',
                'student_email' => $ticket->student?->email ?? 'Not available',

                'created_at' => $ticket->created_at?->format('d M Y, h:i A'),

                'update_url' => route(
                    'staffs.ticket.update',
                    ['ticket' => $ticket]
                ),
            ];

        })->values();


        /*
        |--------------------------------------------------------------------------
        | Summary Card Configuration
        |--------------------------------------------------------------------------
        */

        $metricCards = [
            [
                'label' => 'Total Assigned Tickets',
                'value' => $totalAssigned,
                'badge' => 'All Tickets',
                'color' => 'indigo',
            ],
            [
                'label' => 'Pending',
                'value' => $pendingCount,
                'badge' => 'Awaiting Review',
                'color' => 'amber',
            ],
            [
                'label' => 'Processing',
                'value' => $processingCount,
                'badge' => 'In Progress',
                'color' => 'purple',
            ],
            [
                'label' => 'Done',
                'value' => $doneCount,
                'badge' => 'Completed',
                'color' => 'emerald',
            ],
            [
                'label' => 'Rejected',
                'value' => $rejectedCount,
                'badge' => 'Declined',
                'color' => 'rose',
            ],
        ];

        $metricColors = [
            'indigo' => 'bg-indigo-50 text-indigo-700',
            'amber' => 'bg-amber-50 text-amber-700',
            'purple' => 'bg-purple-50 text-purple-700',
            'emerald' => 'bg-emerald-50 text-emerald-700',
            'rose' => 'bg-rose-50 text-rose-700',
        ];
    @endphp


    <div
        x-data="staffTicketManagement(
            @js($ticketRecords),
            @js($errors->any() && old('_form') === 'edit'),
            @js(old('_ticket_id')),
            @js(old('status')),
            @js(old('rejection_motive'))
        )"
        x-on:keydown.escape.window="closeModals()"
        class="mx-auto w-full min-w-0 space-y-6"
    >

        {{-- =====================================================
             PAGE HEADER
        ====================================================== --}}

        <section class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <div class="mb-3 flex items-center gap-2">

                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>

                    <span class="text-xs font-bold uppercase tracking-widest text-sky-600">
                        Staff Workspace
                    </span>

                </div>

                <h1 class="text-2xl font-extrabold tracking-tight text-indigo-950 sm:text-3xl">
                    Assigned Tickets Oversight
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
                    Monitor student support requests assigned to you, review their
                    details, and update ticket progress.
                </p>

            </div>


            <div class="inline-flex w-fit items-center gap-2 rounded-xl border border-sky-100 bg-sky-50 px-4 py-2.5">

                <svg
                    class="h-5 w-5 text-sky-600"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4 5h16a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-3a2 2 0 0 0 0-4V7a2 2 0 0 1 2-2Z"
                    />
                </svg>

                <span class="text-sm font-bold text-sky-700">
                    {{ number_format($totalAssigned) }} Assigned
                </span>

            </div>

        </section>



        {{-- =====================================================
             FLASH SUCCESS MESSAGE
        ====================================================== --}}

        @if(session('success'))

            <div
                x-data="{ visible: true }"
                x-show="visible"
                x-transition.opacity
                role="status"
                class="flex items-start justify-between gap-4 rounded-xl border border-emerald-200 bg-emerald-50 p-4"
            >

                <div class="flex items-start gap-3">

                    <svg
                        class="mt-0.5 h-5 w-5 shrink-0 text-emerald-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                    >
                        <circle cx="12" cy="12" r="9"/>

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m8 12 3 3 5-6"
                        />
                    </svg>

                    <div>

                        <p class="text-sm font-bold text-emerald-800">
                            Operation Successful
                        </p>

                        <p class="mt-1 text-sm text-emerald-700">
                            {{ session('success') }}
                        </p>

                    </div>

                </div>


                <button
                    type="button"
                    x-on:click="visible = false"
                    aria-label="Dismiss notification"
                    class="rounded-lg p-1 text-emerald-600 hover:bg-emerald-100"
                >

                    <svg class="h-4 w-4" fill="none"
                         stroke="currentColor" viewBox="0 0 24 24"
                         stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M6 18 18 6M6 6l12 12"/>
                    </svg>

                </button>

            </div>

        @endif



        {{-- =====================================================
             VALIDATION ERRORS
        ====================================================== --}}

        @if($errors->any())

            <div role="alert" class="rounded-xl border border-rose-200 bg-rose-50 p-4">

                <p class="text-sm font-bold text-rose-800">
                    Please correct the following errors:
                </p>

                <ul class="mt-2 list-inside list-disc space-y-1 text-xs text-rose-700">

                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif



        {{-- =====================================================
             FIVE SUMMARY METRIC CARDS
        ====================================================== --}}

        <section
            aria-label="Assigned ticket statistics"
            class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5"
        >

            @foreach($metricCards as $index =>$metric)

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">

                    <div class="flex items-start justify-between gap-3">

                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl {{ $metricColors[$metric['color']] }}">

                            @if($index === 0)

                                {{-- Total --}}
                                <svg class="h-6 w-6" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24"
                                     stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M4 5h16a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-3a2 2 0 0 0 0-4V7a2 2 0 0 1 2-2Z"/>
                                </svg>

                            @elseif($index === 1)

                                {{-- Pending --}}
                                <svg class="h-6 w-6" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24"
                                     stroke-width="1.8">
                                    <circle cx="12" cy="12" r="9"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 7v5l3 2"/>
                                </svg>

                            @elseif($index === 2)

                                {{-- Processing --}}
                                <svg class="h-6 w-6" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24"
                                     stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 3a9 9 0 1 0 9 9M12 3v5M12 3l4 3"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 8v4l3 2"/>
                                </svg>

                            @elseif($index === 3)

                                {{-- Done --}}
                                <svg class="h-6 w-6" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24"
                                     stroke-width="1.8">
                                    <circle cx="12" cy="12" r="9"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="m8 12 3 3 5-6"/>
                                </svg>

                            @else

                                {{-- Rejected --}}
                                <svg class="h-6 w-6" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24"
                                     stroke-width="1.8">
                                    <circle cx="12" cy="12" r="9"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="m9 9 6 6M15 9l-6 6"/>
                                </svg>

                            @endif

                        </div>

                    </div>


                    <p class="mt-5 text-xs font-semibold leading-5 text-slate-500">
                        {{ $metric['label'] }}
                    </p>

                    <p class="mt-2 font-mono text-3xl font-extrabold tracking-tight text-indigo-950">
                        {{ number_format($metric['value']) }}
                    </p>

                    <span class="mt-3 inline-flex rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $metricColors[$metric['color']] }}">
                        {{ $metric['badge'] }}
                    </span>

                </div>

            @endforeach

        </section>



        {{-- =====================================================
             TICKET MANAGEMENT TABLE
        ====================================================== --}}

        <section class="min-w-0 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">


            {{-- Table Heading and Filter --}}
            <div class="flex flex-col gap-5 border-b border-slate-100 px-4 py-5 sm:px-6 lg:flex-row lg:items-center lg:justify-between">

                <div>

                    <h2 class="text-lg font-extrabold text-indigo-950">
                        Assigned Ticket Records
                    </h2>

                    <p class="mt-1 text-xs leading-5 text-slate-500">
                        View assigned student requests and manage their lifecycle.
                    </p>

                </div>


                {{-- Reactive Status Filter --}}
                <div class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row sm:items-center">

                    <label
                        for="ticket-status-filter"
                        class="whitespace-nowrap text-xs font-bold text-slate-600"
                    >
                        Filter by Status
                    </label>

                    <select
                        id="ticket-status-filter"
                        x-model="statusFilter"
                        class="w-full min-w-44 rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-medium text-slate-700 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-500/10 sm:w-auto"
                    >

                        <option value="all">All Tickets</option>
                        <option value="pending">Pending</option>
                        <option value="accepted">Accepted</option>
                        <option value="processing">Processing</option>
                        <option value="done">Done</option>
                        <option value="rejected">Rejected</option>

                    </select>

                </div>

            </div>



            {{-- Responsive Table --}}
            <div class="w-full overflow-x-auto">

                <table class="w-full text-left text-sm">

                    <thead class="bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-500">

                        <tr>

                            <th scope="col" class="px-4 py-4 sm:px-6">
                                Ticket / Subject
                            </th>

                            <th scope="col" class="hidden px-4 py-4 md:table-cell">
                                Student
                            </th>

                            <th scope="col" class="hidden px-4 py-4 lg:table-cell">
                                Date Generated
                            </th>

                            <th scope="col" class="px-4 py-4">
                                Status
                            </th>

                            <th scope="col" class="px-4 py-4 text-right sm:px-6">
                                Actions
                            </th>

                        </tr>

                    </thead>



                    <tbody class="divide-y divide-slate-100">

                        @foreach($myAssignedTickets as $ticket)

                            @php
                                $badgeClass = $statusStyles[$ticket->status]
                                    ?? 'bg-slate-100 text-slate-600';
                            @endphp


                            <tr
                                x-show="isVisible(@js($ticket->id))"
                                class="align-middle transition-colors hover:bg-slate-50/70"
                            >

                                {{-- Ticket ID / Subject --}}
                                <td class="px-4 py-5 sm:px-6">

                                    <div class="min-w-0">

                                        <p class="font-mono text-xs font-bold text-sky-600">
                                            #{{ $ticket->id }}
                                        </p>

                                        <p
                                            class="mt-1 max-w-32 truncate font-semibold text-indigo-950 sm:max-w-56"
                                            title="{{ $ticket->subject }}"
                                        >
                                            {{ $ticket->subject }}
                                        </p>


                                        {{-- Mobile Student Name --}}
                                        <p class="mt-1 max-w-32 truncate text-xs text-slate-400 md:hidden">
                                            {{ $ticket->student?->name ?? 'Unknown Student' }}
                                        </p>

                                    </div>

                                </td>



                                {{-- Student --}}
                                <td class="hidden px-4 py-5 md:table-cell">

                                    <p class="max-w-40 truncate font-semibold text-slate-700">
                                        {{ $ticket->student?->name ?? 'Unknown Student' }}
                                    </p>

                                    <p class="mt-1 max-w-40 truncate text-xs text-slate-400">
                                        {{ $ticket->student?->email ?? 'Not available' }}
                                    </p>

                                </td>



                                {{-- Date --}}
                                <td class="hidden whitespace-nowrap px-4 py-5 text-xs text-slate-500 lg:table-cell">

                                    {{ $ticket->created_at?->format('d M Y') ?? '—' }}

                                </td>



                                {{-- Status --}}
                                <td class="px-4 py-5">

                                    <span class="inline-flex rounded-full px-2.5 py-1 text-[11px] font-bold capitalize {{ $badgeClass }}">

                                        {{ $ticket->status }}

                                    </span>

                                </td>



                                {{-- Actions --}}
                                <td class="px-4 py-5 text-right sm:px-6">

                                    <div class="flex items-center justify-end gap-2">


                                        {{-- View Details --}}
                                        <button
                                            type="button"
                                            x-on:click="openDetails(@js($ticket->id))"
                                            title="View Ticket Details"
                                            aria-label="View ticket {{ $ticket->id }}"
                                            class="inline-flex items-center gap-1.5 rounded-lg bg-sky-50 p-2 text-sky-700 transition hover:bg-sky-100 lg:px-3"
                                        >

                                            <svg class="h-4 w-4" fill="none"
                                                 stroke="currentColor" viewBox="0 0 24 24"
                                                 stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M2.25 12s3.5-6 9.75-6 9.75 6 9.75 6-3.5 6-9.75 6-9.75-6-9.75-6Z"/>
                                                <circle cx="12" cy="12" r="3"/>
                                            </svg>

                                            <span class="hidden text-xs font-semibold xl:inline">
                                                Details
                                            </span>

                                        </button>



                                        {{-- Edit Status --}}
                                        <button
                                            type="button"
                                            x-on:click="openEdit(@js($ticket->id))"
                                            title="Edit Ticket Status"
                                            aria-label="Edit status of ticket {{ $ticket->id }}"
                                            class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-50 p-2 text-indigo-700 transition hover:bg-indigo-100 lg:px-3"
                                        >

                                            <svg class="h-4 w-4" fill="none"
                                                 stroke="currentColor" viewBox="0 0 24 24"
                                                 stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="m16 5 3 3M4 20l4.5-1 11-11a2.12 2.12 0 0 0-3-3l-11 11L4 20Z"/>
                                            </svg>

                                            <span class="hidden text-xs font-semibold xl:inline">
                                                Edit Status
                                            </span>

                                        </button>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>



            {{-- Empty / No Matching Tickets --}}
            <div
                x-cloak
                x-show="filteredTickets.length === 0"
                class="px-6 py-16 text-center"
            >

                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">

                    <svg class="h-8 w-8" fill="none"
                         stroke="currentColor" viewBox="0 0 24 24"
                         stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4 5h16a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-3a2 2 0 0 0 0-4V7a2 2 0 0 1 2-2Z"/>
                    </svg>

                </div>

                <h3 class="mt-4 text-base font-bold text-indigo-950">
                    No Tickets Found
                </h3>

                <p
                    class="mt-2 text-sm text-slate-500"
                    x-text="statusFilter === 'all'
                        ? 'There are currently no tickets assigned to you.'
                        : 'No assigned tickets match the selected status.'"
                ></p>

                <button
                    type="button"
                    x-show="statusFilter !== 'all'"
                    x-on:click="statusFilter = 'all'"
                    class="mt-4 text-sm font-bold text-sky-600 transition hover:text-sky-700"
                >
                    Clear Filter
                </button>

            </div>



            {{-- Table Footer --}}
            <div class="border-t border-slate-100 bg-slate-50/50 px-4 py-4 sm:px-6">

                <p class="text-xs text-slate-500" aria-live="polite">

                    Showing
                    <span
                        class="font-bold text-indigo-950"
                        x-text="filteredTickets.length"
                    ></span>

                    of {{ $totalAssigned }} assigned tickets

                </p>

            </div>

        </section>



        {{-- =====================================================
             SHARED MODAL BACKDROP
        ====================================================== --}}

        <template x-teleport="body">

            <div
                x-cloak
                x-show="anyModalOpen"
                x-transition.opacity.duration.200ms
                x-on:click="closeModals()"
                class="fixed inset-0 z-[100] bg-indigo-950/65 backdrop-blur-sm"
                aria-hidden="true"
            ></div>

        </template>



        {{-- =====================================================
             TICKET DETAILS MODAL
        ====================================================== --}}

        <template x-teleport="body">

            <div
                x-cloak
                x-show="showDetailsModal"
                x-transition.opacity.duration.200ms
                x-on:click.self="closeModals()"
                role="dialog"
                aria-modal="true"
                aria-labelledby="staff-ticket-details-title"
                class="fixed inset-0 z-[110] flex items-center justify-center overflow-y-auto p-4 sm:p-6"
            >

                <div class="my-auto w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-2xl">


                    {{-- Modal Header --}}
                    <div class="flex items-start justify-between gap-4 border-b border-slate-100 px-5 py-5 sm:px-6">

                        <div class="min-w-0">

                            <p
                                class="font-mono text-xs font-bold text-sky-600"
                                x-text="activeTicket ? `Ticket #${activeTicket.id}` : ''"
                            ></p>

                            <h2
                                id="staff-ticket-details-title"
                                class="mt-1 break-words text-lg font-extrabold text-indigo-950"
                                x-text="activeTicket?.subject || 'Ticket Details'"
                            ></h2>

                            <p class="mt-1 text-xs text-slate-400">
                                Complete student support request information
                            </p>

                        </div>


                        <button
                            type="button"
                            x-on:click="closeModals()"
                            aria-label="Close ticket details"
                            class="shrink-0 rounded-lg p-2 text-slate-400 hover:bg-slate-100 hover:text-slate-700"
                        >

                            <svg class="h-5 w-5" fill="none"
                                 stroke="currentColor" viewBox="0 0 24 24"
                                 stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M6 18 18 6M6 6l12 12"/>
                            </svg>

                        </button>

                    </div>



                    {{-- Modal Body --}}
                    <div class="max-h-[65vh] space-y-6 overflow-y-auto px-5 py-6 sm:px-6">


                        {{-- Status / Issue Type --}}
                        <div class="flex flex-wrap gap-2">

                            <span
                                class="rounded-full px-3 py-1.5 text-xs font-bold capitalize"
                                x-bind:class="statusClass(activeTicket?.status)"
                                x-text="activeTicket?.status || '—'"
                            ></span>

                            <span
                                class="rounded-full px-3 py-1.5 text-xs font-semibold capitalize"
                                x-bind:class="issueClass(activeTicket?.issueType)"
                                x-text="activeTicket?.issueType || '—'"
                            ></span>

                        </div>



                        {{-- Student Information --}}
                        <section>

                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">
                                Student Information
                            </h3>

                            <div class="mt-3 rounded-xl border border-slate-200 p-4">

                                <div class="flex items-center gap-3">

                                    <div
                                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-indigo-100 font-bold text-indigo-700"
                                        x-text="(activeTicket?.student_name || 'S').charAt(0).toUpperCase()"
                                    ></div>

                                    <div class="min-w-0">

                                        <p
                                            class="break-words text-sm font-bold text-indigo-950"
                                            x-text="activeTicket?.student_name || 'Unknown Student'"
                                        ></p>

                                        <p
                                            class="mt-1 break-all text-xs text-slate-500"
                                            x-text="activeTicket?.student_email || 'Not available'"
                                        ></p>

                                    </div>

                                </div>

                            </div>

                        </section>



                        {{-- Full Description --}}
                        <section>

                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">
                                Ticket Description
                            </h3>

                            <div class="mt-3 rounded-xl border border-slate-200 bg-slate-50 p-4">

                                <p
                                    class="whitespace-pre-wrap break-words text-sm leading-7 text-slate-700"
                                    x-text="activeTicket?.description || 'No description provided.'"
                                ></p>

                            </div>

                        </section>



                        {{-- Rejection Motive --}}
                        <section x-show="activeTicket?.status === 'rejected'">

                            <h3 class="text-xs font-bold uppercase tracking-wider text-rose-600">
                                Rejection Motive
                            </h3>

                            <div class="mt-3 rounded-xl border border-rose-200 bg-rose-50 p-4">

                                <p
                                    class="whitespace-pre-wrap break-words text-sm leading-6 text-rose-700"
                                    x-text="activeTicket?.rejection_motive || 'No rejection motive provided.'"
                                ></p>

                            </div>

                        </section>



                        {{-- Generated Date --}}
                        <div class="flex flex-wrap justify-between gap-3 border-t border-slate-100 pt-5">

                            <span class="text-xs font-medium text-slate-400">
                                Date Generated
                            </span>

                            <span
                                class="text-xs font-semibold text-slate-700"
                                x-text="activeTicket?.created_at || '—'"
                            ></span>

                        </div>

                    </div>



                    {{-- Modal Footer --}}
                    <div class="flex flex-col-reverse gap-3 border-t border-slate-100 px-5 py-5 sm:flex-row sm:justify-end sm:px-6">

                        <button
                            type="button"
                            x-on:click="closeModals()"
                            class="rounded-xl border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                        >
                            Close
                        </button>


                        <button
                            type="button"
                            x-on:click="openEdit(activeTicket?.id)"
                            class="rounded-xl bg-sky-600 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-sky-700"
                        >
                            Edit Status
                        </button>

                    </div>

                </div>

            </div>

        </template>



        {{-- =====================================================
             EDIT / UPDATE TICKET STATUS MODAL
        ====================================================== --}}

        <template x-teleport="body">

            <div
                x-cloak
                x-show="showEditModal"
                x-transition.opacity.duration.200ms
                x-on:click.self="closeModals()"
                role="dialog"
                aria-modal="true"
                aria-labelledby="staff-edit-ticket-title"
                class="fixed inset-0 z-[110] flex items-center justify-center overflow-y-auto p-4 sm:p-6"
            >

                <div class="my-auto w-full max-w-xl overflow-hidden rounded-2xl bg-white shadow-2xl">


                    {{-- Modal Header --}}
                    <div class="flex items-start justify-between gap-4 border-b border-slate-100 px-5 py-5 sm:px-6">

                        <div class="min-w-0">

                            <h2 id="staff-edit-ticket-title" class="text-lg font-extrabold text-indigo-950">
                                Update Ticket Status
                            </h2>

                            <p
                                class="mt-1 font-mono text-xs text-slate-500"
                                x-text="activeTicket ? `Ticket #${activeTicket.id}` : ''"
                            ></p>

                        </div>


                        <button
                            type="button"
                            x-on:click="closeModals()"
                            aria-label="Close edit modal"
                            class="rounded-lg p-2 text-slate-400 hover:bg-slate-100 hover:text-slate-700"
                        >

                            <svg class="h-5 w-5" fill="none"
                                 stroke="currentColor" viewBox="0 0 24 24"
                                 stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M6 18 18 6M6 6l12 12"/>
                            </svg>

                        </button>

                    </div>



                    {{-- Update Form --}}
                    <form
                        method="POST"
                        x-bind:action="activeTicket?.update_url || ''"
                        x-on:submit="submitUpdate($event)"
                    >

                        @csrf
                        @method('PATCH')

                        <input type="hidden" name="_form" value="edit">

                        <input
                            type="hidden"
                            name="_ticket_id"
                            x-bind:value="activeTicket?.id || ''"
                        >



                        {{-- Form Body --}}
                        <div class="max-h-[65vh] space-y-5 overflow-y-auto px-5 py-6 sm:px-6">


                            {{-- Ticket Context --}}
                            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">

                                <p class="text-xs font-bold uppercase tracking-wide text-slate-400">
                                    Selected Ticket
                                </p>

                                <p
                                    class="mt-2 break-words text-sm font-bold text-indigo-950"
                                    x-text="activeTicket?.subject || '—'"
                                ></p>

                                <p
                                    class="mt-1 text-xs text-slate-500"
                                    x-text="activeTicket?.student_name || 'Unknown Student'"
                                ></p>

                            </div>



                            {{-- Current Status --}}
                            <div class="flex flex-wrap items-center justify-between gap-3">

                                <span class="text-sm font-semibold text-slate-600">
                                    Current Status
                                </span>

                                <span
                                    class="rounded-full px-3 py-1.5 text-xs font-bold capitalize"
                                    x-bind:class="statusClass(activeTicket?.status)"
                                    x-text="activeTicket?.status || '—'"
                                ></span>

                            </div>



                            {{-- Status Dropdown --}}
                            <div>

                                <label
                                    for="edit-ticket-status"
                                    class="mb-2 block text-sm font-semibold text-slate-700"
                                >
                                    Update Status

                                    <span class="text-rose-500">*</span>
                                </label>


                                <select
                                    id="edit-ticket-status"
                                    name="status"
                                    x-model="editForm.status"
                                    required
                                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10"
                                >

                                    <option value="">Select Ticket Status</option>

                                    <option value="pending">Pending</option>

                                    <option value="accepted">Accepted</option>

                                    <option value="processing">Processing</option>

                                    <option value="done">Done</option>

                                    <option value="rejected">Rejected</option>

                                </select>

                                <p class="mt-2 text-xs text-slate-400">
                                    Select the appropriate lifecycle stage for this request.
                                </p>

                            </div>



                            {{-- =============================================
                                 CONDITIONAL REJECTION MOTIVE
                            ============================================== --}}

                            <div
                                x-cloak
                                x-show="editForm.status === 'rejected'"
                                x-transition.opacity.duration.200ms
                            >

                                <label
                                    for="edit-rejection-motive"
                                    class="mb-2 block text-sm font-semibold text-rose-700"
                                >
                                    Rejection Reason

                                    <span class="text-rose-500">*</span>
                                </label>


                                <textarea
                                    id="edit-rejection-motive"
                                    name="rejection_motive"
                                    x-model="editForm.rejection_motive"
                                    x-bind:required="editForm.status === 'rejected'"
                                    x-bind:disabled="editForm.status !== 'rejected'"
                                    rows="4"
                                    placeholder="Clearly explain why this ticket is being rejected..."
                                    class="w-full resize-y rounded-xl border border-rose-200 bg-rose-50/40 px-4 py-3 text-sm leading-6 text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-rose-400 focus:ring-4 focus:ring-rose-500/10"
                                ></textarea>


                                <div class="mt-3 flex items-start gap-2 rounded-lg bg-amber-50 p-3">

                                    <svg
                                        class="mt-0.5 h-4 w-4 shrink-0 text-amber-600"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        stroke-width="2"
                                    >
                                        <circle cx="12" cy="12" r="9"/>

                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M12 8v4M12 16h.01"/>
                                    </svg>

                                    <p class="text-xs leading-5 text-amber-800">
                                        The student will see this rejection reason.
                                        Provide clear, professional feedback explaining
                                        what needs to be corrected.
                                    </p>

                                </div>

                            </div>



                            {{-- Status Notice --}}
                            <div
                                x-show="editForm.status !== 'rejected' && editForm.status !== ''"
                                class="rounded-xl border border-sky-100 bg-sky-50 p-4"
                            >

                                <p class="text-xs leading-5 text-sky-800">
                                    Saving will update the ticket to
                                    <strong
                                        class="capitalize"
                                        x-text="editForm.status"
                                    ></strong>.
                                </p>

                            </div>

                        </div>



                        {{-- Modal Footer --}}
                        <div class="flex flex-col-reverse gap-3 border-t border-slate-100 px-5 py-5 sm:flex-row sm:justify-end sm:px-6">

                            <button
                                type="button"
                                x-on:click="closeModals()"
                                x-bind:disabled="loading"
                                class="rounded-xl border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50 disabled:opacity-50"
                            >
                                Cancel
                            </button>


                            <button
                                type="submit"
                                x-bind:disabled="loading || !editForm.status || !activeTicket?.update_url"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-sky-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-sky-700 disabled:cursor-not-allowed disabled:opacity-60"
                            >


                                {{-- Loading Spinner --}}
                                <svg
                                    x-cloak
                                    x-show="loading"
                                    class="h-4 w-4 animate-spin"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                >

                                    <circle
                                        cx="12"
                                        cy="12"
                                        r="10"
                                        stroke="currentColor"
                                        stroke-width="4"
                                        class="opacity-25"
                                    />

                                    <path
                                        fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4Z"
                                    />

                                </svg>


                                <span x-text="loading ? 'Saving Changes...' : 'Save Changes'"></span>

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </template>

    </div>



    {{-- =========================================================
         ALPINE COMPONENT SCRIPT
    ====================================================== --}}

    <script>
        function staffTicketManagement(
            records,
            reopenEdit = false,
            oldTicketId = null,
            oldStatus = null,
            oldRejectionMotive = null
        ) {

            return {

                /*
                |--------------------------------------------------------------------------
                | Data
                |--------------------------------------------------------------------------
                */

                tickets: records,

                statusFilter: 'all',

                showDetailsModal: false,
                showEditModal: false,

                activeTicket: null,

                loading: false,

                editForm: {
                    status: '',
                    rejection_motive: ''
                },


                /*
                |--------------------------------------------------------------------------
                | Computed Properties
                |--------------------------------------------------------------------------
                */

                get anyModalOpen() {

                    return this.showDetailsModal || this.showEditModal;

                },


                get filteredTickets() {

                    if (this.statusFilter === 'all') {
                        return this.tickets;
                    }

                    return this.tickets.filter(ticket =>
                        ticket.status === this.statusFilter
                    );

                },


                /*
                |--------------------------------------------------------------------------
                | Row Filtering
                |--------------------------------------------------------------------------
                */

                isVisible(ticketId) {

                    return this.filteredTickets.some(ticket =>
                        String(ticket.id) === String(ticketId)
                    );

                },


                /*
                |--------------------------------------------------------------------------
                | Ticket Selection
                |--------------------------------------------------------------------------
                */

                findTicket(ticketId) {

                    return this.tickets.find(ticket =>
                        String(ticket.id) === String(ticketId)
                    ) ?? null;

                },


                /*
                |--------------------------------------------------------------------------
                | Details Modal
                |--------------------------------------------------------------------------
                */

                openDetails(ticketId) {

                    const ticket = this.findTicket(ticketId);

                    if (!ticket) return;

                    this.closeModals();

                    this.activeTicket = ticket;

                    this.showDetailsModal = true;

                },


                /*
                |--------------------------------------------------------------------------
                | Edit Status Modal
                |--------------------------------------------------------------------------
                */

                openEdit(ticketId) {

                    const ticket = this.findTicket(ticketId);

                    if (!ticket || !ticket.update_url) return;

                    this.closeModals();

                    this.activeTicket = ticket;

                    this.editForm = {
                        status: ticket.status ?? '',
                        rejection_motive: ticket.rejection_motive ?? ''
                    };

                    this.showEditModal = true;

                },


                /*
                |--------------------------------------------------------------------------
                | Close Modals
                |--------------------------------------------------------------------------
                */

                closeModals() {

                    if (this.loading) return;

                    this.showDetailsModal = false;
                    this.showEditModal = false;

                    this.activeTicket = null;

                },


                /*
                |--------------------------------------------------------------------------
                | Submit Status Update
                |--------------------------------------------------------------------------
                */

                submitUpdate(event) {

                    if (this.loading) {

                        event.preventDefault();
                        return;

                    }

                    if (!this.activeTicket?.update_url) {

                        event.preventDefault();
                        return;

                    }

                    if (!this.editForm.status) {

                        event.preventDefault();
                        event.target.reportValidity();

                        return;

                    }

                    /*
                     * Rejection motive is mandatory when rejecting.
                     */
                    if (
                        this.editForm.status === 'rejected' &&
                        !this.editForm.rejection_motive.trim()
                    ) {

                        event.preventDefault();

                        const motiveField = event.target.querySelector(
                            '[name="rejection_motive"]'
                        );

                        if (motiveField) {

                            motiveField.setCustomValidity(
                                'Please provide a reason for rejecting this ticket.'
                            );

                            motiveField.reportValidity();

                            motiveField.addEventListener('input', () => {
                                motiveField.setCustomValidity('');
                            }, { once: true });

                        }

                        return;

                    }

                    if (!event.target.checkValidity()) {

                        event.preventDefault();
                        event.target.reportValidity();

                        return;

                    }

                    this.loading = true;

                },


                /*
                |--------------------------------------------------------------------------
                | Status Badge Styling
                |--------------------------------------------------------------------------
                */

                statusClass(status) {

                    const classes = {
                        pending: 'bg-amber-100 text-amber-700',
                        accepted: 'bg-sky-100 text-sky-700',
                        processing: 'bg-purple-100 text-purple-700',
                        done: 'bg-emerald-100 text-emerald-700',
                        rejected: 'bg-rose-100 text-rose-700'
                    };

                    return classes[status] ?? 'bg-slate-100 text-slate-600';

                },


                /*
                |--------------------------------------------------------------------------
                | Issue Type Badge Styling
                |--------------------------------------------------------------------------
                */

                issueClass(type) {

                    const classes = {
                        academic: 'bg-indigo-50 text-indigo-700',
                        finance: 'bg-emerald-50 text-emerald-700',
                        system: 'bg-sky-50 text-sky-700'
                    };

                    return classes[type] ?? 'bg-slate-100 text-slate-600';

                },


                /*
                |--------------------------------------------------------------------------
                | Initialization
                |--------------------------------------------------------------------------
                */

                init() {

                    /*
                     * Reopen edit modal after Laravel validation errors.
                     */
                    if (reopenEdit && oldTicketId) {

                        this.openEdit(oldTicketId);

                        if (this.showEditModal) {

                            this.editForm.status =
                                oldStatus ?? this.editForm.status;

                            this.editForm.rejection_motive =
                                oldRejectionMotive ?? this.editForm.rejection_motive;

                        }

                    }


                    /*
                     * Lock background scrolling while a modal is open.
                     */
                    this.$watch('anyModalOpen', isOpen => {

                        document.body.classList.toggle(
                            'overflow-hidden',
                            isOpen
                        );

                    });

                    if (this.anyModalOpen) {
                        document.body.classList.add('overflow-hidden');
                    }


                    /*
                     * Reset loading state after browser back navigation.
                     */
                    window.addEventListener('pageshow', () => {
                        this.loading = false;
                    });

                }

            };

        }
    </script>

</x-staffLayout>