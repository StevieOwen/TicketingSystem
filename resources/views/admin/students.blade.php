<x-adminLayout>


    <div
        x-data="studentManagement()"
        x-on:keydown.escape.window="closeModals()"
        class="mx-auto w-full min-w-0 space-y-6"
    >

        {{-- =====================================================
             PAGE HEADER
        ====================================================== --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div class="min-w-0">

                <h1 class="text-2xl font-bold tracking-tight text-indigo-950">
                    Student Directory
                </h1>

                <p class="mt-2 text-sm leading-relaxed text-slate-500">
                    View and manage registered university student accounts.
                </p>

            </div>

            {{-- Student Counter --}}
            <div class="inline-flex w-fit shrink-0 items-center gap-2 rounded-xl border border-sky-100 bg-sky-50 px-4 py-2.5">

                <svg
                    class="h-4 w-4 text-sky-600"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m2 8 10-5 10 5-10 5L2 8ZM5 10v6c0 2.5 3.1 4.5 7 4.5s7-2 7-4.5v-6M22 8v7"
                    />
                </svg>

                <span class="text-xs font-semibold text-sky-700">
                    {{ number_format($students->count()) }} Registered Students
                </span>

            </div>

        </div>


        {{-- =====================================================
             VALIDATION ERRORS
        ====================================================== --}}
        @if ($errors->any())

            <div
                role="alert"
                class="rounded-xl border border-rose-200 bg-rose-50 p-4"
            >

                <div class="flex items-start gap-3">

                    <svg
                        class="mt-0.5 h-5 w-5 shrink-0 text-rose-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 9v4m0 4h.01M10.29 3.86 1.82 18.14A2 2 0 0 0 3.54 21h16.92a2 2 0 0 0 1.72-2.86L13.71 3.86a2 2 0 0 0-3.42 0Z"
                        />
                    </svg>

                    <div>

                        <p class="text-sm font-semibold text-rose-800">
                            Please correct the following errors:
                        </p>

                        <ul class="mt-2 list-inside list-disc space-y-1 text-xs text-rose-700">

                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach

                        </ul>

                    </div>

                </div>

            </div>

        @endif


        {{-- =====================================================
             STUDENT DIRECTORY TABLE
        ====================================================== --}}
        <section class="min-w-0 overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">

            {{-- Table Heading --}}
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 px-4 py-5 sm:px-6">

                <div>

                    <h2 class="text-base font-bold text-indigo-950">
                        Registered Students
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        Browse student profiles and update account information.
                    </p>

                </div>

                <span class="rounded-full bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-700">
                    Student Accounts
                </span>

            </div>


            {{-- Responsive Table --}}
            <div class="w-full overflow-x-auto">

                <table class="w-full text-left text-sm">

                    <thead class="bg-slate-50/80 text-xs font-semibold uppercase tracking-wider text-slate-500">

                        <tr>

                            <th scope="col" class="px-3 py-4 sm:px-6">
                                Name
                            </th>

                            <th scope="col" class="hidden px-4 py-4 sm:table-cell">
                                Registration No.
                            </th>

                            <th scope="col" class="hidden px-4 py-4 md:table-cell">
                                Email
                            </th>

                            <th scope="col" class="hidden px-4 py-4 xl:table-cell">
                                Department
                            </th>

                            <th scope="col" class="hidden px-4 py-4 lg:table-cell">
                                Status
                            </th>

                            <th scope="col" class="px-3 py-4 text-right sm:px-6">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @forelse ($students as $student)

                            @php
                                /*
                                 * Generate the update URL server-side.
                                 * Laravel route parameter: {user}
                                 */
                                $studentData = [
                                    'id' => $student->id,
                                    'name' => $student->name,
                                    'email' => $student->email,
                                    'regnumber' => $student->regnumber,
                                    'department' => $student->department,
                                    'status' => $student->status,
                                    'created_at' => $student->created_at?->format('d M Y'),
                                    'update_url' => route('admin.students_update', [
                                        'user' => $student->id
                                    ]),
                                ];

                                $isActive = $student->status === 'active';
                            @endphp


                            <tr class="transition-colors hover:bg-slate-50/70">

                                {{-- Student Name --}}
                                <td class="px-3 py-4 sm:px-6">

                                    <div class="flex min-w-0 items-center gap-2 sm:gap-3">

                                        {{-- Avatar --}}
                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-sky-100 text-sm font-bold uppercase text-sky-700 sm:h-10 sm:w-10">
                                            {{ strtoupper(substr($student->name, 0, 1)) }}
                                        </div>

                                        <div class="min-w-0">

                                            <p class="max-w-[110px] truncate font-semibold text-slate-800 sm:max-w-[150px] lg:max-w-none">
                                                {{ $student->name }}
                                            </p>

                                            {{-- Mobile Registration Number --}}
                                            <p class="mt-0.5 max-w-[110px] truncate font-mono text-[11px] text-slate-400 sm:hidden">
                                                {{ $student->regnumber ?: 'No Reg. Number' }}
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                {{-- Registration Number --}}
                                <td class="hidden px-4 py-4 sm:table-cell">

                                    <span class="inline-flex max-w-[180px] truncate rounded-lg bg-slate-100 px-2.5 py-1.5 font-mono text-xs font-medium text-slate-700">
                                        {{ $student->regnumber ?: '—' }}
                                    </span>

                                </td>


                                {{-- Email --}}
                                <td class="hidden px-4 py-4 md:table-cell">

                                    <span
                                        class="block max-w-[190px] truncate text-slate-600"
                                        title="{{ $student->email }}"
                                    >
                                        {{ $student->email }}
                                    </span>

                                </td>


                                {{-- Department --}}
                                <td class="hidden px-4 py-4 text-slate-600 xl:table-cell">

                                    <span
                                        class="block max-w-[170px] truncate"
                                        title="{{ $student->department }}"
                                    >
                                        {{ $student->department ?: '—' }}
                                    </span>

                                </td>


                                {{-- Status --}}
                                <td class="hidden px-4 py-4 lg:table-cell">

                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold
                                        {{ $isActive
                                            ? 'bg-emerald-100 text-emerald-700'
                                            : 'bg-slate-100 text-slate-600' }}"
                                    >

                                        <span
                                            class="h-1.5 w-1.5 rounded-full
                                            {{ $isActive ? 'bg-emerald-500' : 'bg-slate-400' }}"
                                        ></span>

                                        {{ ucfirst($student->status) }}

                                    </span>

                                </td>


                                {{-- Actions --}}
                                <td class="px-2 py-4 sm:px-6">

                                    <div class="flex items-center justify-end gap-1">

                                        {{-- Show More --}}
                                        <button
                                            type="button"
                                            x-on:click="openDetails({{ Js::from($studentData) }})"
                                            title="Show More"
                                            aria-label="View details for {{ $student->name }}"
                                            class="rounded-lg p-2 text-slate-500 transition hover:bg-sky-50 hover:text-sky-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-sky-600"
                                        >

                                            <svg
                                                class="h-5 w-5"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.8"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M2.25 12s3.5-6 9.75-6 9.75 6 9.75 6-3.5 6-9.75 6-9.75-6-9.75-6Z"
                                                />
                                                <circle cx="12" cy="12" r="3"/>
                                            </svg>

                                        </button>


                                        {{-- Edit Student --}}
                                        <button
                                            type="button"
                                            x-on:click="openEdit({{ Js::from($studentData) }})"
                                            title="Edit Student"
                                            aria-label="Edit {{ $student->name }}"
                                            class="rounded-lg p-2 text-slate-500 transition hover:bg-indigo-50 hover:text-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-sky-600"
                                        >

                                            <svg
                                                class="h-5 w-5"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.8"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="m16 5 3 3M4 20l4.5-1 11-11a2.12 2.12 0 0 0-3-3l-11 11L4 20Z"
                                                />
                                            </svg>

                                        </button>

                                    </div>

                                </td>

                            </tr>


                        @empty

                            {{-- Empty State --}}
                            <tr>

                                <td colspan="6" class="px-6 py-16 text-center">

                                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-sky-50 text-sky-500">

                                        <svg
                                            class="h-8 w-8"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="m2 8 10-5 10 5-10 5L2 8ZM5 10v6c0 2.5 3.1 4.5 7 4.5s7-2 7-4.5v-6M22 8v7"
                                            />
                                        </svg>

                                    </div>

                                    <h3 class="mt-4 text-sm font-bold text-slate-800">
                                        No registered students found
                                    </h3>

                                    <p class="mt-2 text-xs text-slate-500">
                                        Student accounts will appear here once they register.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Table Footer --}}
            @if ($students->count() > 0)

                <div class="border-t border-slate-100 bg-slate-50/50 px-4 py-4 sm:px-6">

                    <p class="text-xs text-slate-500">
                        Showing {{ $students->count() }} registered students.
                        Select the eye icon to view complete student details.
                    </p>

                </div>

            @endif

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
                class="fixed inset-0 z-[100] bg-indigo-950/60 backdrop-blur-sm"
                aria-hidden="true"
            ></div>

        </template>


        {{-- =====================================================
             EDIT STUDENT MODAL
        ====================================================== --}}
        <template x-teleport="body">

            <div
                x-cloak
                x-show="showEditModal"
                x-transition.opacity.duration.200ms
                x-on:click.self="closeModals()"
                role="dialog"
                aria-modal="true"
                aria-labelledby="edit-student-title"
                class="fixed inset-0 z-[110] flex items-center justify-center overflow-y-auto p-4 sm:p-6"
            >

                <div class="my-auto w-full max-w-xl overflow-hidden rounded-2xl bg-white shadow-2xl">

                    {{-- Modal Header --}}
                    <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">

                        <div class="min-w-0">

                            <h2 id="edit-student-title" class="text-lg font-bold text-indigo-950">
                                Edit Student
                            </h2>

                            <p
                                class="mt-1 truncate text-xs text-slate-500"
                                x-text="activeStudent?.name || ''"
                            ></p>

                        </div>

                        <button
                            type="button"
                            x-on:click="closeModals()"
                            aria-label="Close edit modal"
                            class="rounded-lg p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                        >

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 18 18 6M6 6l12 12"
                                />
                            </svg>

                        </button>

                    </div>


                    {{-- Edit Form --}}
                    <form
                        method="POST"
                        x-bind:action="activeStudent?.update_url || ''"
                        x-on:submit="submitForm($event)"
                    >

                        @csrf
                        @method('PUT')

                        <input type="hidden" name="_form" value="edit">


                        <div class="max-h-[65vh] space-y-5 overflow-y-auto px-6 py-6">

                            {{-- Full Name --}}
                            <div>

                                <label
                                    for="edit-student-name"
                                    class="mb-2 block text-sm font-semibold text-slate-700"
                                >
                                    Full Name <span class="text-rose-500">*</span>
                                </label>

                                <input
                                    id="edit-student-name"
                                    type="text"
                                    name="name"
                                    x-model="editForm.name"
                                    required
                                    autocomplete="name"
                                    placeholder="Student full name"
                                    class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10"
                                >

                            </div>


                            {{-- Email --}}
                            <div>

                                <label
                                    for="edit-student-email"
                                    class="mb-2 block text-sm font-semibold text-slate-700"
                                >
                                    Email Address <span class="text-rose-500">*</span>
                                </label>

                                <input
                                    id="edit-student-email"
                                    type="email"
                                    name="email"
                                    x-model="editForm.email"
                                    required
                                    autocomplete="email"
                                    placeholder="student@university.ac.rw"
                                    class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10"
                                >

                            </div>


                            {{-- Registration Number --}}
                            <div>

                                <label
                                    for="edit-student-regnumber"
                                    class="mb-2 block text-sm font-semibold text-slate-700"
                                >
                                    Registration Number <span class="text-rose-500">*</span>
                                </label>

                                <input
                                    id="edit-student-regnumber"
                                    type="text"
                                    name="regnumber"
                                    x-model="editForm.regnumber"
                                    required
                                    placeholder="e.g. BIT-2024-0089"
                                    class="w-full rounded-xl border border-slate-200 px-4 py-3 font-mono text-sm outline-none transition focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10"
                                >

                            </div>


                            {{-- Department --}}
                            <div>

                                <label
                                    for="edit-student-department"
                                    class="mb-2 block text-sm font-semibold text-slate-700"
                                >
                                    Department <span class="text-rose-500">*</span>
                                </label>

                                <input
                                    id="edit-student-department"
                                    type="text"
                                    name="department"
                                    x-model="editForm.department"
                                    required
                                    placeholder="e.g. Information Technology"
                                    class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10"
                                >

                            </div>


                            {{-- Status --}}
                            <div>

                                <label
                                    for="edit-student-status"
                                    class="mb-2 block text-sm font-semibold text-slate-700"
                                >
                                    Account Status <span class="text-rose-500">*</span>
                                </label>

                                <select
                                    id="edit-student-status"
                                    name="status"
                                    x-model="editForm.status"
                                    required
                                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10"
                                >

                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>

                                </select>

                            </div>

                        </div>


                        {{-- Modal Footer --}}
                        <div class="flex flex-col-reverse gap-3 border-t border-slate-100 px-6 py-5 sm:flex-row sm:justify-end">

                            <button
                                type="button"
                                x-on:click="closeModals()"
                                class="rounded-xl border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
                            >
                                Cancel
                            </button>

                            <button
                                type="submit"
                                x-bind:disabled="loading"
                                class="flex items-center justify-center gap-2 rounded-xl bg-sky-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700 disabled:cursor-not-allowed disabled:opacity-60"
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


        {{-- =====================================================
             STUDENT DETAILS MODAL
        ====================================================== --}}
        <template x-teleport="body">

            <div
                x-cloak
                x-show="showDetailsModal"
                x-transition.opacity.duration.200ms
                x-on:click.self="closeModals()"
                role="dialog"
                aria-modal="true"
                aria-labelledby="student-details-title"
                class="fixed inset-0 z-[110] flex items-center justify-center overflow-y-auto p-4"
            >

                <div class="my-auto w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl">

                    {{-- Header --}}
                    <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">

                        <h2 id="student-details-title" class="text-lg font-bold text-indigo-950">
                            Student Details
                        </h2>

                        <button
                            type="button"
                            x-on:click="closeModals()"
                            aria-label="Close student details"
                            class="rounded-lg p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                        >

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 18 18 6M6 6l12 12"
                                />
                            </svg>

                        </button>

                    </div>


                    {{-- Details Body --}}
                    <div class="max-h-[65vh] overflow-y-auto px-6 py-6">

                        {{-- Student Profile --}}
                        <div class="mb-6 flex items-center gap-4">

                            <div
                                class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-sky-100 text-xl font-bold text-sky-700"
                                x-text="activeStudent?.name?.charAt(0)?.toUpperCase() || 'S'"
                            ></div>

                            <div class="min-w-0">

                                <p
                                    class="break-words font-bold text-indigo-950"
                                    x-text="activeStudent?.name || ''"
                                ></p>

                                <p
                                    class="mt-1 break-words font-mono text-xs text-slate-500"
                                    x-text="activeStudent?.regnumber || 'No Registration Number'"
                                ></p>

                            </div>

                        </div>


                        {{-- Student Information --}}
                        <dl class="divide-y divide-slate-100 rounded-xl border border-slate-200 px-4">

                            {{-- Name --}}
                            <div class="py-3">

                                <dt class="text-xs font-medium text-slate-400">
                                    Full Name
                                </dt>

                                <dd
                                    class="mt-1 break-words text-sm font-semibold text-slate-800"
                                    x-text="activeStudent?.name || '—'"
                                ></dd>

                            </div>


                            {{-- Email --}}
                            <div class="py-3">

                                <dt class="text-xs font-medium text-slate-400">
                                    Email Address
                                </dt>

                                <dd
                                    class="mt-1 break-all text-sm font-semibold text-slate-800"
                                    x-text="activeStudent?.email || '—'"
                                ></dd>

                            </div>


                            {{-- Registration Number --}}
                            <div class="py-3">

                                <dt class="text-xs font-medium text-slate-400">
                                    Registration Number
                                </dt>

                                <dd
                                    class="mt-1 break-words font-mono text-sm font-semibold text-indigo-950"
                                    x-text="activeStudent?.regnumber || '—'"
                                ></dd>

                            </div>


                            {{-- Department --}}
                            <div class="py-3">

                                <dt class="text-xs font-medium text-slate-400">
                                    Department
                                </dt>

                                <dd
                                    class="mt-1 break-words text-sm font-semibold text-slate-800"
                                    x-text="activeStudent?.department || '—'"
                                ></dd>

                            </div>


                            {{-- Status --}}
                            <div class="py-3">

                                <dt class="text-xs font-medium text-slate-400">
                                    Account Status
                                </dt>

                                <dd class="mt-2">

                                    <span
                                        class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold capitalize"
                                        x-bind:class="activeStudent?.status === 'active'
                                            ? 'bg-emerald-100 text-emerald-700'
                                            : 'bg-slate-100 text-slate-600'"
                                        x-text="activeStudent?.status || '—'"
                                    ></span>

                                </dd>

                            </div>


                            {{-- Created Date --}}
                            <div class="py-3">

                                <dt class="text-xs font-medium text-slate-400">
                                    Created Date
                                </dt>

                                <dd
                                    class="mt-1 text-sm font-semibold text-slate-800"
                                    x-text="activeStudent?.created_at || '—'"
                                ></dd>

                            </div>

                        </dl>

                    </div>


                    {{-- Footer --}}
                    <div class="border-t border-slate-100 px-6 py-5">

                        <button
                            type="button"
                            x-on:click="closeModals()"
                            class="w-full rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                        >
                            Close
                        </button>

                    </div>

                </div>

            </div>

        </template>

    </div>


    {{-- =========================================================
         ALPINE.JS COMPONENT
    ========================================================== --}}
    <script>
        document.addEventListener('alpine:init', () => {

            Alpine.data('studentManagement', () => ({

                showEditModal: false,
                showDetailsModal: false,

                activeStudent: null,

                loading: false,

                editForm: {
                    name: '',
                    email: '',
                    regnumber: '',
                    department: '',
                    status: 'active'
                },

                get anyModalOpen() {
                    return this.showEditModal || this.showDetailsModal;
                },

                openEdit(student) {

                    this.closeModals();

                    this.activeStudent = student;

                    this.editForm = {
                        name: student.name ?? '',
                        email: student.email ?? '',
                        regnumber: student.regnumber ?? '',
                        department: student.department ?? '',
                        status: student.status ?? 'active'
                    };

                    this.showEditModal = true;

                },

                openDetails(student) {

                    this.closeModals();

                    this.activeStudent = student;
                    this.showDetailsModal = true;

                },

                closeModals() {

                    if (this.loading) return;

                    this.showEditModal = false;
                    this.showDetailsModal = false;

                    this.activeStudent = null;

                },

                submitForm(event) {

                    if (this.loading) {
                        event.preventDefault();
                        return;
                    }

                    if (!this.activeStudent?.update_url) {
                        event.preventDefault();
                        return;
                    }

                    if (!event.target.checkValidity()) {

                        event.preventDefault();
                        event.target.reportValidity();

                        return;
                    }

                    this.loading = true;

                },

                init() {

                    // Restore edit modal after a Laravel validation error.
                    const oldStudentId = @js(old('_student_id'));

                    const students = @js(
                        $students->map(fn ($student) => [
                            'id' => $student->id,
                            'name' => $student->name,
                            'email' => $student->email,
                            'regnumber' => $student->regnumber,
                            'department' => $student->department,
                            'status' => $student->status,
                            'created_at' => $student->created_at?->format('d M Y'),
                            'update_url' => route('admin.students_update', [
                                'user' => $student->id
                            ]),
                        ])->values()
                    );

                    if (oldStudentId && @js($errors->any())) {

                        const student = students.find(
                            item => String(item.id) === String(oldStudentId)
                        );

                        if (student) {

                            this.openEdit(student);

                            this.editForm = {
                                name: @js(old('name')),
                                email: @js(old('email')),
                                regnumber: @js(old('regnumber')),
                                department: @js(old('department')),
                                status: @js(old('status', 'active'))
                            };

                        }

                    }

                    // Prevent scrolling behind open modals.
                    this.$watch('anyModalOpen', (isOpen) => {

                        document.body.classList.toggle(
                            'overflow-hidden',
                            isOpen
                        );

                    });

                    if (this.anyModalOpen) {
                        document.body.classList.add('overflow-hidden');
                    }

                    // Restore loading state on browser back navigation.
                    window.addEventListener('pageshow', () => {
                        this.loading = false;
                    });

                }

            }));

        });
    </script>

</x-adminLayout>

