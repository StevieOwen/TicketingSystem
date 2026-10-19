
<x-adminLayout>

    <div
        x-data="staffManagement()"
        x-on:keydown.escape.window="closeModals()"
        class="mx-auto w-full min-w-0 space-y-6"
    >

        {{-- =====================================================
             PAGE HEADER
        ====================================================== --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div class="min-w-0">
                <h1 class="text-2xl font-bold tracking-tight text-indigo-950">
                    Staff Management
                </h1>

                <p class="mt-2 text-sm leading-relaxed text-slate-500">
                    Manage university officers, departments, roles, and account statuses.
                </p>
            </div>

            <button
                type="button"
                x-on:click="openAdd()"
                class="inline-flex w-full shrink-0 items-center justify-center gap-2 rounded-xl bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-sky-700 hover:shadow-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600 sm:w-auto"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 5v14M5 12h14"/>
                </svg>

                Add Staff
            </button>

        </div>


        {{-- =====================================================
             VALIDATION SUMMARY
        ====================================================== --}}
        @if ($errors->any())

            <div
                role="alert"
                class="rounded-xl border border-rose-200 bg-rose-50 p-4"
            >
                <div class="flex items-start gap-3">

                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-rose-600"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 9v4m0 4h.01M10.29 3.86 1.82 18.14A2 2 0 0 0 3.54 21h16.92a2 2 0 0 0 1.72-2.86L13.71 3.86a2 2 0 0 0-3.42 0Z"/>
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
             STAFF DIRECTORY
        ====================================================== --}}
        <section class="min-w-0 overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">

            {{-- Table Header --}}
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 px-4 py-5 sm:px-6">

                <div>
                    <h2 class="text-base font-bold text-indigo-950">
                        Staff Directory
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        View and manage university staff accounts.
                    </p>
                </div>

                <span class="rounded-full bg-sky-50 px-3 py-1.5 text-xs font-semibold text-sky-700">
                    {{ $staffs->count() }} Staff Members
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

                            <th scope="col" class="hidden px-4 py-4 md:table-cell">
                                Email
                            </th>

                            <th scope="col" class="hidden px-4 py-4 lg:table-cell">
                                Role
                            </th>

                            <th scope="col" class="hidden px-4 py-4 xl:table-cell">
                                Department
                            </th>

                            <th scope="col" class="hidden px-4 py-4 sm:table-cell">
                                Status
                            </th>

                            <th scope="col" class="px-3 py-4 text-right sm:px-6">
                                Actions
                            </th>
                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse ($staffs as $staff)

                            @php
                                /*
                                 * Generate Laravel URLs on the server.
                                 * The route parameter is named {user}.
                                 */
                                $staffData = [
                                    'id' => $staff->user_id,
                                    'name' => $staff->name,
                                    'email' => $staff->email,
                                    'role' => $staff->role,
                                    'department' => $staff->department,
                                    'status' => $staff->status,
                                    'created_at' => $staff->created_at?->format('d M Y'),
                                    'update_url' => route('admin.staffs_update', [
                                        'user' => $staff->user_id
                                    ]),
                                    'delete_url' => route('admin.staffs_delete', [
                                        'user' => $staff->user_id
                                    ]),
                                ];

                                $isActive = $staff->status === 'active';
                            @endphp

                            <tr class="transition-colors hover:bg-slate-50/70">

                                {{-- Name --}}
                                <td class="px-3 py-4 sm:px-6">

                                    <div class="flex min-w-0 items-center gap-2 sm:gap-3">

                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-indigo-100 text-sm font-bold uppercase text-indigo-700 sm:h-10 sm:w-10">
                                            {{ strtoupper(substr($staff->name, 0, 1)) }}
                                        </div>

                                        <div class="min-w-0">

                                            <p class="max-w-[100px] truncate font-semibold text-slate-800 sm:max-w-[160px] lg:max-w-none">
                                                {{ $staff->name }}
                                            </p>

                                            <p class="mt-0.5 max-w-[100px] truncate text-[11px] text-slate-400 sm:max-w-[160px] md:hidden">
                                                {{ $staff->role }}
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                {{-- Email --}}
                                <td class="hidden px-4 py-4 md:table-cell">

                                    <span
                                        class="block max-w-[190px] truncate text-slate-600"
                                        title="{{ $staff->email }}"
                                    >
                                        {{ $staff->email }}
                                    </span>

                                </td>


                                {{-- Role --}}
                                <td class="hidden px-4 py-4 lg:table-cell">

                                    <span class="inline-flex whitespace-nowrap rounded-lg bg-indigo-50 px-2.5 py-1 text-xs font-semibold text-indigo-700">
                                        {{ $staff->role }}
                                    </span>

                                </td>


                                {{-- Department --}}
                                <td class="hidden px-4 py-4 text-slate-600 xl:table-cell">

                                    <span class="block max-w-[160px] truncate" title="{{ $staff->department }}">
                                        {{ $staff->department ?: '—' }}
                                    </span>

                                </td>


                                {{-- Status --}}
                                <td class="hidden px-4 py-4 sm:table-cell">

                                    <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold
                                        {{ $isActive
                                            ? 'bg-emerald-100 text-emerald-700'
                                            : 'bg-slate-100 text-slate-600' }}"
                                    >

                                        <span class="h-1.5 w-1.5 rounded-full
                                            {{ $isActive ? 'bg-emerald-500' : 'bg-slate-400' }}">
                                        </span>

                                        {{ ucfirst($staff->status) }}

                                    </span>

                                </td>


                                {{-- Actions --}}
                                <td class="px-2 py-4 sm:px-6">

                                    <div class="flex items-center justify-end gap-0.5 sm:gap-1">

                                        {{-- Show More --}}
                                        <button
                                            type="button"
                                            x-on:click="openDetails({{ Js::from($staffData) }})"
                                            title="Show More"
                                            aria-label="View details for {{ $staff->name }}"
                                            class="rounded-lg p-1.5 text-slate-500 transition hover:bg-sky-50 hover:text-sky-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-sky-600 sm:p-2"
                                        >

                                            <svg class="h-4 w-4 sm:h-5 sm:w-5"
                                                 fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M2.25 12s3.5-6 9.75-6 9.75 6 9.75 6-3.5 6-9.75 6-9.75-6-9.75-6Z"/>
                                                <circle cx="12" cy="12" r="3"/>
                                            </svg>

                                        </button>


                                        {{-- Edit --}}
                                        <button
                                            type="button"
                                            x-on:click="openEdit({{ Js::from($staffData) }})"
                                            title="Edit Staff"
                                            aria-label="Edit {{ $staff->name }}"
                                            class="rounded-lg p-1.5 text-slate-500 transition hover:bg-indigo-50 hover:text-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-sky-600 sm:p-2"
                                        >

                                            <svg class="h-4 w-4 sm:h-5 sm:w-5"
                                                 fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="m16 5 3 3M4 20l4.5-1 11-11a2.12 2.12 0 0 0-3-3l-11 11L4 20Z"/>
                                            </svg>

                                        </button>


                                        {{-- Delete --}}
                                        <button
                                            type="button"
                                            x-on:click="openDelete({{ Js::from($staffData) }})"
                                            title="Delete Staff"
                                            aria-label="Delete {{ $staff->name }}"
                                            class="rounded-lg p-1.5 text-slate-500 transition hover:bg-rose-50 hover:text-rose-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-rose-600 sm:p-2"
                                        >

                                            <svg class="h-4 w-4 sm:h-5 sm:w-5"
                                                 fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M3 6h18M8 6V4h8v2m3 0-1 14H6L5 6m5 4v6m4-6v6"/>
                                            </svg>

                                        </button>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            {{-- Empty State --}}
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">

                                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">

                                        <svg class="h-7 w-7" fill="none"
                                             stroke="currentColor" viewBox="0 0 24 24"
                                             stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM22 21v-2a4 4 0 0 0-3-3.87"/>
                                        </svg>

                                    </div>

                                    <h3 class="mt-4 text-sm font-bold text-slate-800">
                                        No staff members found
                                    </h3>

                                    <p class="mt-2 text-xs text-slate-500">
                                        Create your first staff account to get started.
                                    </p>

                                    <button
                                        type="button"
                                        x-on:click="openAdd()"
                                        class="mt-5 rounded-xl bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-sky-700"
                                    >
                                        Add Staff Member
                                    </button>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Table Footer --}}
            @if ($staffs->count() > 0)

                <div class="border-t border-slate-100 bg-slate-50/50 px-4 py-4 sm:px-6">

                    <p class="text-xs text-slate-500">
                        Showing {{ $staffs->count() }} staff members.
                        Select the eye icon to view complete staff information.
                    </p>

                </div>

            @endif

        </section>


        {{-- =====================================================
             MODAL BACKDROP
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
             ADD STAFF MODAL
        ====================================================== --}}
        <template x-teleport="body">

            <div
                x-cloak
                x-show="showAddModal"
                x-transition.opacity.duration.200ms
                x-on:click.self="closeModals()"
                role="dialog"
                aria-modal="true"
                aria-labelledby="add-staff-title"
                class="fixed inset-0 z-[110] flex items-center justify-center overflow-y-auto p-4 sm:p-6"
            >

                <div class="my-auto w-full max-w-xl overflow-hidden rounded-2xl bg-white shadow-2xl">

                    {{-- Header --}}
                    <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">

                        <div>
                            <h2 id="add-staff-title" class="text-lg font-bold text-indigo-950">
                                Add Staff Member
                            </h2>

                            <p class="mt-1 text-xs text-slate-500">
                                Create a new university staff account.
                            </p>
                        </div>

                        <button
                            type="button"
                            x-on:click="closeModals()"
                            aria-label="Close modal"
                            class="rounded-lg p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                        >
                            <svg class="h-5 w-5" fill="none"
                                 stroke="currentColor" viewBox="0 0 24 24"
                                 stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M6 18 18 6M6 6l12 12"/>
                            </svg>
                        </button>

                    </div>


                    {{-- Create Form --}}
                    <form
                        method="POST"
                        action="{{ route('admin.staffs_store') }}"
                        x-on:submit="submitForm($event)"
                    >

                        @csrf

                        <input type="hidden" name="_form" value="add">

                        <div class="max-h-[65vh] space-y-5 overflow-y-auto px-6 py-6">

                            {{-- Name --}}
                            <div>
                                <label for="add-name" class="mb-2 block text-sm font-semibold text-slate-700">
                                    Full Name <span class="text-rose-500">*</span>
                                </label>

                                <input
                                    id="add-name"
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    required
                                    autocomplete="name"
                                    placeholder="e.g. Jean Paul Habimana"
                                    class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10"
                                >

                                @error('name')
                                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>


                            {{-- Email --}}
                            <div>
                                <label for="add-email" class="mb-2 block text-sm font-semibold text-slate-700">
                                    Email Address <span class="text-rose-500">*</span>
                                </label>

                                <input
                                    id="add-email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autocomplete="email"
                                    placeholder="staff@university.ac.rw"
                                    class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10"
                                >

                                @error('email')
                                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>


                            {{-- Role and Status --}}
                            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                                <div>
                                    <label for="add-role" class="mb-2 block text-sm font-semibold text-slate-700">
                                        Role <span class="text-rose-500">*</span>
                                    </label>

                                    <select
                                        id="add-role"
                                        name="role"
                                        required
                                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10"
                                    >
                                        <option value="">Select role</option>

                                        @foreach (['Academic officer', 'IT officer', 'Finance officer', 'Admin'] as $role)
                                            <option value="{{ $role }}" @selected(old('role') === $role)>
                                                {{ $role }}
                                            </option>
                                        @endforeach

                                    </select>

                                    @error('role')
                                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                                    @enderror
                                </div>


                                <div>
                                    <label for="add-status" class="mb-2 block text-sm font-semibold text-slate-700">
                                        Status <span class="text-rose-500">*</span>
                                    </label>

                                    <select
                                        id="add-status"
                                        name="status"
                                        required
                                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10"
                                    >
                                        <option value="active" @selected(old('status', 'active') === 'active')>
                                            Active
                                        </option>

                                        <option value="inactive" @selected(old('status') === 'inactive')>
                                            Inactive
                                        </option>
                                    </select>

                                    @error('status')
                                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>


                            {{-- Department --}}
                            <div>
                                <label for="add-department" class="mb-2 block text-sm font-semibold text-slate-700">
                                    Department <span class="text-rose-500">*</span>
                                </label>

                                <!-- <input
                                    id="add-department"
                                    type="text"
                                    name="department"
                                    value="{{ old('department') }}"
                                    required
                                    placeholder="e.g. Information Technology"
                                    class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10"
                                > -->
                                <select name="department"  id="add-department" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10">
                                    <option value="">Select Department</option>
                                    <option value="Computer Science" {{ old('department') == 'Computer Science' ? 'selected' : '' }}>Computer Science</option>
                                    <option value="Information Technology" {{ old('department') == 'Information Technology' ? 'selected' : '' }}>Information Technology</option>
                                    <option value="Business Information Technology" {{ old('department') == 'Business Information Technology' ? 'selected' : '' }}>Business Information Technology</option>
                                    <option value="Software Engineering" {{ old('department') == 'Software Engineering' ? 'selected' : '' }}>Software Engineering</option>
                                    <option value="Networks & Communication" {{ old('department') == 'Networks & Communication' ? 'selected' : '' }}>Networks & Communication</option>
                                </select>

                                @error('department')
                                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>


                            {{-- Password --}}
                            <div>
                                <label for="add-password" class="mb-2 block text-sm font-semibold text-slate-700">
                                    Password <span class="text-rose-500">*</span>
                                </label>

                                <input
                                    id="add-password"
                                    type="password"
                                    name="password"
                                    required
                                    minlength="8"
                                    autocomplete="new-password"
                                    placeholder="Minimum 8 characters"
                                    class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10"
                                >

                                @error('password')
                                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="add-passwordConfirmation" class="mb-2 block text-sm font-semibold text-slate-700">
                                    Password Confirmation<span class="text-rose-500">*</span>
                                </label>

                                <input
                                    id="add-passwordConfirmation"
                                    type="password"
                                    name="password_confirmation"
                                    required
                                    minlength="8"
                                    autocomplete="new-password"
                                    placeholder="Minimum 8 characters"
                                    class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10"
                                >

                                @error('password_confirmation')
                                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>


                        {{-- Footer --}}
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

                                <svg
                                    x-cloak
                                    x-show="loading"
                                    class="h-4 w-4 animate-spin"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                >
                                    <circle cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"
                                            class="opacity-25"/>
                                    <path fill="currentColor"
                                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4Z"/>
                                </svg>

                                <span x-text="loading ? 'Creating...' : 'Create Staff Member'"></span>

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </template>


        {{-- =====================================================
             EDIT STAFF MODAL
        ====================================================== --}}
        <template x-teleport="body">

            <div
                x-cloak
                x-show="showEditModal"
                x-transition.opacity.duration.200ms
                x-on:click.self="closeModals()"
                role="dialog"
                aria-modal="true"
                aria-labelledby="edit-staff-title"
                class="fixed inset-0 z-[110] flex items-center justify-center overflow-y-auto p-4 sm:p-6"
            >

                <div class="my-auto w-full max-w-xl overflow-hidden rounded-2xl bg-white shadow-2xl">

                    {{-- Header --}}
                    <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">

                        <div class="min-w-0">
                            <h2 id="edit-staff-title" class="text-lg font-bold text-indigo-950">
                                Edit Staff Member
                            </h2>

                            <p
                                class="mt-1 truncate text-xs text-slate-500"
                                x-text="activeStaff?.name || ''"
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


                    {{-- Edit Form --}}
                    <form
                        method="POST"
                        x-bind:action="activeStaff?.update_url || ''"
                        x-on:submit="submitForm($event)"
                    >

                        @csrf
                        @method('PATCH')

                        <input type="hidden" name="_form" value="edit">

                        <div class="max-h-[65vh] space-y-5 overflow-y-auto px-6 py-6">

                            {{-- Email --}}
                            <div>
                                <label for="edit-email" class="mb-2 block text-sm font-semibold text-slate-700">
                                    Email Address
                                </label>

                                <input
                                    id="edit-email"
                                    type="email"
                                    name="email"
                                    x-model="editForm.email"
                                    required
                                    class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10"
                                >
                            </div>


                            {{-- Role --}}
                            <div>
                                <label for="edit-role" class="mb-2 block text-sm font-semibold text-slate-700">
                                    Role
                                </label>

                                <select
                                    id="edit-role"
                                    name="role"
                                    x-model="editForm.role"
                                    required
                                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10"
                                >
                                    <option value="Academic officer">Academic officer</option>
                                    <option value="IT officer">IT officer</option>
                                    <option value="Finance officer">Finance officer</option>
                                    <option value="Admin">Admin</option>
                                </select>
                            </div>


                            {{-- Department --}}
                            <div>
                                <label for="edit-department" class="mb-2 block text-sm font-semibold text-slate-700">
                                    Department
                                </label>

                                <input
                                    id="edit-department"
                                    type="text"
                                    name="department"
                                    x-model="editForm.department"
                                    required
                                    class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10"
                                >
                            </div>


                            {{-- Status --}}
                            <div>
                                <label for="edit-status" class="mb-2 block text-sm font-semibold text-slate-700">
                                    Account Status
                                </label>

                                <select
                                    id="edit-status"
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


                        {{-- Footer --}}
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
                                class="flex items-center justify-center gap-2 rounded-xl bg-sky-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-sky-700 disabled:opacity-60"
                            >

                                <svg x-cloak x-show="loading"
                                     class="h-4 w-4 animate-spin"
                                     viewBox="0 0 24 24" fill="none">
                                    <circle cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"
                                            class="opacity-25"/>
                                    <path fill="currentColor"
                                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4Z"/>
                                </svg>

                                <span x-text="loading ? 'Saving...' : 'Save Changes'"></span>

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </template>


        {{-- =====================================================
             DELETE CONFIRMATION MODAL
        ====================================================== --}}
        <template x-teleport="body">

            <div
                x-cloak
                x-show="showDeleteModal"
                x-transition.opacity.duration.200ms
                x-on:click.self="closeModals()"
                role="alertdialog"
                aria-modal="true"
                aria-labelledby="delete-staff-title"
                aria-describedby="delete-staff-description"
                class="fixed inset-0 z-[110] flex items-center justify-center p-4"
            >

                <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl sm:p-8">

                    <div class="flex items-start justify-between">

                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-rose-100 text-rose-600">

                            <svg class="h-7 w-7" fill="none"
                                 stroke="currentColor" viewBox="0 0 24 24"
                                 stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 9v4m0 4h.01M10.29 3.86 1.82 18.14A2 2 0 0 0 3.54 21h16.92a2 2 0 0 0 1.72-2.86L13.71 3.86a2 2 0 0 0-3.42 0Z"/>
                            </svg>

                        </div>

                        <button
                            type="button"
                            x-on:click="closeModals()"
                            aria-label="Close confirmation"
                            class="rounded-lg p-2 text-slate-400 hover:bg-slate-100"
                        >
                            <svg class="h-5 w-5" fill="none"
                                 stroke="currentColor" viewBox="0 0 24 24"
                                 stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M6 18 18 6M6 6l12 12"/>
                            </svg>
                        </button>

                    </div>


                    <h2 id="delete-staff-title" class="mt-5 text-xl font-bold text-indigo-950">
                        Delete Staff Member?
                    </h2>

                    <p id="delete-staff-description" class="mt-3 text-sm leading-6 text-slate-600">
                        Are you sure you want to delete
                        <strong class="text-slate-900" x-text="activeStaff?.name || ''"></strong>?
                        This action cannot be undone.
                    </p>


                    {{-- Delete Form --}}
                    <form
                        method="POST"
                        x-bind:action="activeStaff?.delete_url || ''"
                        x-on:submit="submitForm($event)"
                        class="mt-7 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end"
                    >

                        @csrf
                        @method('DELETE')

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
                            class="flex items-center justify-center gap-2 rounded-xl bg-rose-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-rose-700 disabled:opacity-60"
                        >

                            <svg x-cloak x-show="loading"
                                 class="h-4 w-4 animate-spin"
                                 viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"
                                        class="opacity-25"/>
                                <path fill="currentColor"
                                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4Z"/>
                            </svg>

                            <span x-text="loading ? 'Deleting...' : 'Confirm Delete'"></span>

                        </button>

                    </form>

                </div>

            </div>

        </template>


        {{-- =====================================================
             STAFF DETAILS MODAL
        ====================================================== --}}
        <template x-teleport="body">

            <div
                x-cloak
                x-show="showDetailsModal"
                x-transition.opacity.duration.200ms
                x-on:click.self="closeModals()"
                role="dialog"
                aria-modal="true"
                aria-labelledby="staff-details-title"
                class="fixed inset-0 z-[110] flex items-center justify-center overflow-y-auto p-4"
            >

                <div class="my-auto w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl">

                    {{-- Header --}}
                    <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">

                        <h2 id="staff-details-title" class="text-lg font-bold text-indigo-950">
                            Staff Details
                        </h2>

                        <button
                            type="button"
                            x-on:click="closeModals()"
                            aria-label="Close details"
                            class="rounded-lg p-2 text-slate-400 hover:bg-slate-100"
                        >
                            <svg class="h-5 w-5" fill="none"
                                 stroke="currentColor" viewBox="0 0 24 24"
                                 stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M6 18 18 6M6 6l12 12"/>
                            </svg>
                        </button>

                    </div>


                    <div class="max-h-[65vh] overflow-y-auto px-6 py-6">

                        {{-- Profile --}}
                        <div class="mb-6 flex items-center gap-4">

                            <div
                                class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-indigo-100 text-xl font-bold text-indigo-700"
                                x-text="activeStaff?.name?.charAt(0)?.toUpperCase() || 'S'"
                            ></div>

                            <div class="min-w-0">

                                <p
                                    class="break-words font-bold text-indigo-950"
                                    x-text="activeStaff?.name || ''"
                                ></p>

                                <p
                                    class="mt-1 break-all text-xs text-slate-500"
                                    x-text="activeStaff?.email || ''"
                                ></p>

                            </div>

                        </div>


                        {{-- Information List --}}
                        <dl class="divide-y divide-slate-100 rounded-xl border border-slate-200 px-4">

                            <div class="py-3">
                                <dt class="text-xs font-medium text-slate-400">
                                    Full Name
                                </dt>

                                <dd class="mt-1 break-words text-sm font-semibold text-slate-800"
                                    x-text="activeStaff?.name || '—'"></dd>
                            </div>


                            <div class="py-3">
                                <dt class="text-xs font-medium text-slate-400">
                                    Email Address
                                </dt>

                                <dd class="mt-1 break-all text-sm font-semibold text-slate-800"
                                    x-text="activeStaff?.email || '—'"></dd>
                            </div>


                            <div class="py-3">
                                <dt class="text-xs font-medium text-slate-400">
                                    Role
                                </dt>

                                <dd class="mt-1 text-sm font-semibold text-slate-800"
                                    x-text="activeStaff?.role || '—'"></dd>
                            </div>


                            <div class="py-3">
                                <dt class="text-xs font-medium text-slate-400">
                                    Department
                                </dt>

                                <dd class="mt-1 break-words text-sm font-semibold text-slate-800"
                                    x-text="activeStaff?.department || '—'"></dd>
                            </div>


                            <div class="py-3">
                                <dt class="text-xs font-medium text-slate-400">
                                    Status
                                </dt>

                                <dd class="mt-2">

                                    <span
                                        class="inline-flex rounded-full px-3 py-1 text-xs font-semibold capitalize"
                                        x-bind:class="activeStaff?.status === 'active'
                                            ? 'bg-emerald-100 text-emerald-700'
                                            : 'bg-slate-100 text-slate-600'"
                                        x-text="activeStaff?.status || '—'"
                                    ></span>

                                </dd>
                            </div>


                            <div class="py-3">
                                <dt class="text-xs font-medium text-slate-400">
                                    Created Date
                                </dt>

                                <dd class="mt-1 text-sm font-semibold text-slate-800"
                                    x-text="activeStaff?.created_at || '—'"></dd>
                            </div>

                        </dl>

                    </div>


                    {{-- Footer --}}
                    <div class="border-t border-slate-100 px-6 py-5">

                        <button
                            type="button"
                            x-on:click="closeModals()"
                            class="w-full rounded-xl bg-sky-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-sky-700"
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

            Alpine.data('staffManagement', () => ({

                showAddModal: @js($errors->any() && old('_form') === 'add'),
                showEditModal: false,
                showDeleteModal: false,
                showDetailsModal: false,

                activeStaff: null,
                loading: false,

                editForm: {
                    email: '',
                    role: '',
                    department: '',
                    status: 'active'
                },

                get anyModalOpen() {
                    return this.showAddModal ||
                           this.showEditModal ||
                           this.showDeleteModal ||
                           this.showDetailsModal;
                },

                openAdd() {
                    this.closeModals();

                    this.showAddModal = true;
                },

                openEdit(staff) {
                    this.closeModals();

                    this.activeStaff = staff;

                    this.editForm = {
                        email: staff.email ?? '',
                        role: staff.role ?? '',
                        department: staff.department ?? '',
                        status: staff.status ?? 'active'
                    };

                    this.showEditModal = true;
                },

                openDelete(staff) {
                    this.closeModals();

                    this.activeStaff = staff;
                    this.showDeleteModal = true;
                },

                openDetails(staff) {
                    this.closeModals();

                    this.activeStaff = staff;
                    this.showDetailsModal = true;
                },

                closeModals() {
                    if (this.loading) return;

                    this.showAddModal = false;
                    this.showEditModal = false;
                    this.showDeleteModal = false;
                    this.showDetailsModal = false;

                    this.activeStaff = null;
                },

                submitForm(event) {

                    if (this.loading) {
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

                    // Lock background scrolling while a modal is open.
                    this.$watch('anyModalOpen', (isOpen) => {
                        document.body.classList.toggle(
                            'overflow-hidden',
                            isOpen
                        );
                    });

                    // Apply initial scroll lock if validation reopens modal.
                    if (this.anyModalOpen) {
                        document.body.classList.add('overflow-hidden');
                    }

                    // Restore submission state on browser back navigation.
                    window.addEventListener('pageshow', () => {
                        this.loading = false;
                    });

                }

            }));

        });
    </script>

</x-adminLayout>

