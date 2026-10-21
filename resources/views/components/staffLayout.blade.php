
@props([
    'title' => 'Staff Dashboard',
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }} | UniTicket Staff</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    {{-- Application Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>

    @stack('styles')

</head>


<body class="min-h-screen bg-slate-50 text-slate-700 antialiased">

@php

    $staff = auth()->user();

    $staffName = $staff?->name ?? 'Staff Member';

    $staffRole = $staff?->role ?? 'Staff';

    $staffDepartment = $staff?->department ?? 'Department not assigned';

    $formattedRole = match (strtolower($staffRole)) {
        'academic officer', 'academic_officer' => 'Academic Officer',
        'it officer', 'it_officer' => 'IT Officer',
        'finance officer', 'finance_officer' => 'Finance Officer',
        default => ucwords(str_replace('_', ' ', $staffRole)),
    };

    $staffInitials = collect(preg_split('/\s+/', trim($staffName)))
        ->filter()
        ->take(2)
        ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
        ->implode('');

@endphp


<div
    x-data="{
        sidebarOpen: false,
        profileOpen: false
    }"
    x-on:keydown.escape.window="
        sidebarOpen = false;
        profileOpen = false;
    "
    class="min-h-screen"
>

    {{-- =========================================================
         MOBILE SIDEBAR BACKDROP
    ========================================================== --}}

    <div
        x-cloak
        x-show="sidebarOpen"
        x-transition.opacity.duration.200ms
        x-on:click="sidebarOpen = false"
        class="fixed inset-0 z-40 bg-indigo-950/60 backdrop-blur-sm lg:hidden"
        aria-hidden="true"
    ></div>



    {{-- =========================================================
         STAFF SIDEBAR
    ========================================================== --}}

    <aside
        id="staff-sidebar"
        x-bind:class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-50 flex w-72 flex-col border-r border-slate-200 bg-white shadow-xl transition-transform duration-300 ease-in-out lg:translate-x-0 lg:shadow-none"
        aria-label="Staff navigation"
    >

        {{-- Branding --}}
        <div class="flex h-20 shrink-0 items-center justify-between border-b border-slate-100 px-6">

            <a
                href="{{ route('staffs.overview') }}"
                class="flex min-w-0 items-center gap-3"
            >

                {{-- Brand Icon --}}
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-indigo-950 text-white shadow-sm">

                    <svg
                        class="h-6 w-6"
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

                </div>


                {{-- Brand Text --}}
                <div class="min-w-0">

                    <h1 class="truncate text-base font-extrabold tracking-tight text-indigo-950">
                        University Portal
                    </h1>

                    <p class="mt-0.5 text-[10px] font-bold uppercase tracking-[0.15em] text-sky-600">
                        Staff Workspace
                    </p>

                </div>

            </a>


            {{-- Close Mobile Sidebar --}}
            <button
                type="button"
                x-on:click="sidebarOpen = false"
                aria-label="Close navigation"
                class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-indigo-950 lg:hidden"
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



        {{-- =====================================================
             SIDEBAR NAVIGATION
        ====================================================== --}}

        <nav
            aria-label="Main navigation"
            class="flex-1 space-y-2 overflow-y-auto px-4 py-6"
        >

            <p class="mb-4 px-3 text-[11px] font-bold uppercase tracking-widest text-slate-400">
                Workspace
            </p>


            {{-- My Tickets --}}
            <a
                href="{{ route('staffs.overview') }}"
                @class([
                    'group flex items-center gap-3 rounded-xl border-l-4 px-4 py-3 text-sm transition-all duration-200',

                    'border-sky-600 bg-sky-50 font-bold text-sky-700 shadow-sm' =>
                        request()->routeIs('staffs.overview*'),

                    'border-transparent font-medium text-slate-600 hover:bg-slate-50 hover:text-indigo-950' =>
                        !request()->routeIs('staffs.overview*'),
                ])
                @if(request()->routeIs('staffs.overview*'))
                    aria-current="page"
                @endif
            >

                <svg
                    class="h-5 w-5 shrink-0 transition-colors"
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

                    <path
                        stroke-linecap="round"
                        stroke-dasharray="2 3"
                        d="M13 5v14"
                    />
                </svg>

                <span>My Tickets</span>


                @if(request()->routeIs('staffs.overview*'))

                    <span class="ml-auto h-2 w-2 rounded-full bg-sky-600"></span>

                @endif

            </a>



            {{-- Account Settings --}}
            <a
                href="{{ route('staffs.settings') }}"
                @class([
                    'group flex items-center gap-3 rounded-xl border-l-4 px-4 py-3 text-sm transition-all duration-200',

                    'border-sky-600 bg-sky-50 font-bold text-sky-700 shadow-sm' =>
                        request()->routeIs('staffs.settings*'),

                    'border-transparent font-medium text-slate-600 hover:bg-slate-50 hover:text-indigo-950' =>
                        !request()->routeIs('staffs.settings*'),
                ])
                @if(request()->routeIs('staffs.settings*'))
                    aria-current="page"
                @endif
            >

                <svg
                    class="h-5 w-5 shrink-0 transition-colors"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                >
                    <circle cx="12" cy="12" r="3"/>

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06-2 2-.06-.06A1.65 1.65 0 0 0 15.9 18.5a1.65 1.65 0 0 0-1 .92V20h-3v-.58a1.65 1.65 0 0 0-1-.92 1.65 1.65 0 0 0-1.82.33l-.06.06-2-2 .06-.06A1.65 1.65 0 0 0 7.4 15a1.65 1.65 0 0 0-.92-1H6v-3h.48a1.65 1.65 0 0 0 .92-1 1.65 1.65 0 0 0-.33-1.82l-.06-.06 2-2 .06.06A1.65 1.65 0 0 0 10.9 6.5a1.65 1.65 0 0 0 1-.92V5h3v.58a1.65 1.65 0 0 0 1 .92 1.65 1.65 0 0 0 1.82-.33l.06-.06 2 2-.06.06A1.65 1.65 0 0 0 19.4 10a1.65 1.65 0 0 0 .92 1H21v3h-.68a1.65 1.65 0 0 0-.92 1Z"
                    />
                </svg>

                <span>Account Settings</span>


                @if(request()->routeIs('staffs.settings*'))

                    <span class="ml-auto h-2 w-2 rounded-full bg-sky-600"></span>

                @endif

            </a>

        </nav>


        {{-- No staff profile/footer here, as requested --}}

    </aside>



    {{-- =========================================================
         MAIN APPLICATION AREA
    ========================================================== --}}

    <div class="flex min-h-screen min-w-0 flex-col lg:pl-72">


        {{-- =====================================================
             STICKY TOPBAR
        ====================================================== --}}

        <header class="sticky top-0 z-30 h-20 shrink-0 border-b border-slate-200 bg-white/95 backdrop-blur-xl">

            <div class="flex h-full items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">


                {{-- Left: Mobile Toggle + Page Title --}}
                <div class="flex min-w-0 items-center gap-3">


                    {{-- Mobile Hamburger --}}
                    <button
                        type="button"
                        x-on:click="sidebarOpen = true; profileOpen = false"
                        aria-label="Open navigation"
                        aria-controls="staff-sidebar"
                        x-bind:aria-expanded="sidebarOpen"
                        class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-200 text-indigo-950 transition hover:border-sky-200 hover:bg-sky-50 lg:hidden"
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
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                        </svg>

                    </button>



                    {{-- Breadcrumb / Title --}}
                    <div class="min-w-0">

                        <div class="hidden items-center gap-2 text-xs font-medium text-slate-400 sm:flex">

                            <span>Staff Workspace</span>

                            <svg
                                class="h-3.5 w-3.5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m9 18 6-6-6-6"
                                />
                            </svg>

                            <span class="truncate text-sky-600">
                                {{ $title }}
                            </span>

                        </div>

                        <h2 class="truncate text-base font-extrabold tracking-tight text-indigo-950 sm:mt-1 sm:text-lg">
                            {{ $title }}
                        </h2>

                    </div>

                </div>



                {{-- =================================================
                     RIGHT: PROFILE DROPDOWN
                ================================================== --}}

                <div
                    class="relative shrink-0"
                    x-on:click.outside="profileOpen = false"
                >

                    {{-- Profile Trigger --}}
                    <button
                        type="button"
                        id="staff-profile-trigger"
                        x-on:click="profileOpen = !profileOpen"
                        x-bind:aria-expanded="profileOpen"
                        aria-controls="staff-profile-menu"
                        aria-haspopup="menu"
                        class="flex items-center gap-2 rounded-xl border border-transparent p-1.5 transition hover:border-slate-200 hover:bg-slate-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600 sm:gap-3 sm:px-3"
                    >


                        {{-- Avatar --}}
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-indigo-950 text-sm font-bold text-white shadow-sm">

                            {{ $staffInitials ?: 'ST' }}

                        </div>


                        {{-- Name / Role --}}
                        <div class="hidden max-w-40 min-w-0 text-left sm:block">

                            <p class="truncate text-sm font-bold text-indigo-950">
                                {{ $staffName }}
                            </p>

                            <p class="truncate text-xs text-slate-500">
                                {{ $formattedRole }}
                            </p>

                        </div>


                        {{-- Chevron --}}
                        <svg
                            class="h-4 w-4 text-slate-400 transition-transform duration-200"
                            x-bind:class="profileOpen ? 'rotate-180' : ''"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m6 9 6 6 6-6"
                            />
                        </svg>

                    </button>



                    {{-- =================================================
                         PROFILE DROPDOWN PANEL
                    ================================================== --}}

                    <div
                        id="staff-profile-menu"
                        x-cloak
                        x-show="profileOpen"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                        role="menu"
                        aria-labelledby="staff-profile-trigger"
                        class="absolute right-0 top-full z-50 mt-3 w-[min(20rem,calc(100vw-2rem))] origin-top-right overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl shadow-indigo-950/10"
                    >


                        {{-- Staff Information Header --}}
                        <div class="border-b border-slate-100 bg-slate-50/70 px-5 py-5">

                            <div class="flex items-start gap-3">

                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-indigo-100 text-sm font-extrabold text-indigo-700">

                                    {{ $staffInitials ?: 'ST' }}

                                </div>


                                <div class="min-w-0 flex-1">

                                    <p class="break-words text-sm font-extrabold text-indigo-950">
                                        {{ $staffName }}
                                    </p>

                                    <span class="mt-1.5 inline-flex rounded-full bg-sky-100 px-2.5 py-1 text-[11px] font-bold text-sky-700">

                                        {{ $formattedRole }}

                                    </span>

                                </div>

                            </div>


                            {{-- Department --}}
                            <div class="mt-4 rounded-xl border border-slate-200 bg-white px-3 py-3">

                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                    Department
                                </p>

                                <p class="mt-1 break-words text-xs font-semibold text-slate-700">
                                    {{ $staffDepartment }}
                                </p>

                            </div>

                        </div>



                        {{-- Dropdown Actions --}}
                        <div class="p-2">


                            {{-- Notifications --}}
                            <button
                                type="button"
                                role="menuitem"
                                x-on:click="
                                    profileOpen = false;
                                    $dispatch('staff-notifications-open');
                                "
                                class="flex w-full items-center gap-3 rounded-xl px-3 py-3 text-left text-sm font-medium text-slate-600 transition hover:bg-sky-50 hover:text-sky-700"
                            >

                                <svg
                                    class="h-5 w-5 shrink-0"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9ZM10 21h4"
                                    />
                                </svg>

                                <span>Notifications</span>

                                <svg
                                    class="ml-auto h-4 w-4 text-slate-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m9 18 6-6-6-6"
                                    />
                                </svg>

                            </button>


                            {{-- Account Settings Shortcut --}}
                            <a
                                href="{{ route('staffs.settings') }}"
                                role="menuitem"
                                class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium text-slate-600 transition hover:bg-sky-50 hover:text-sky-700"
                            >

                                <svg
                                    class="h-5 w-5 shrink-0"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.8"
                                >
                                    <circle cx="12" cy="12" r="3"/>

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 2v2M12 20v2M4.93 4.93l1.42 1.42M17.65 17.65l1.42 1.42M2 12h2M20 12h2M4.93 19.07l1.42-1.42M17.65 6.35l1.42-1.42"
                                    />
                                </svg>

                                <span>Account Settings</span>

                            </a>

                        </div>



                        {{-- Divider --}}
                        <div class="mx-4 border-t border-slate-100"></div>



                        {{-- Logout --}}
                        <div class="p-2">

                            <form
                                method="POST"
                                action="{{ route('logout') }}"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    role="menuitem"
                                    class="flex w-full items-center gap-3 rounded-xl px-3 py-3 text-left text-sm font-semibold text-rose-600 transition hover:bg-rose-50"
                                >

                                    <svg
                                        class="h-5 w-5 shrink-0"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.8"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"
                                        />
                                    </svg>

                                    <span>Logout</span>

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </header>



        {{-- =====================================================
             MAIN CONTENT
        ====================================================== --}}

        <main
            id="main-content"
            class="min-w-0 flex-1 px-4 py-6 sm:px-6 lg:px-8 lg:py-8"
        >

            <div class="mx-auto w-full max-w-7xl space-y-6">


                {{-- =================================================
                     SUCCESS FLASH MESSAGE
                ================================================== --}}

                @if(session('success'))

                    <div
                        x-data="{ visible: true }"
                        x-show="visible"
                        x-transition.opacity
                        role="status"
                        class="flex items-start justify-between gap-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-4 shadow-sm"
                    >

                        <div class="flex items-start gap-3">

                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">

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
                                        d="m5 12 4 4L19 6"
                                    />
                                </svg>

                            </div>

                            <div>

                                <p class="text-sm font-bold text-emerald-800">
                                    Success
                                </p>

                                <p class="mt-1 text-sm leading-6 text-emerald-700">
                                    {{ session('success') }}
                                </p>

                            </div>

                        </div>


                        <button
                            type="button"
                            x-on:click="visible = false"
                            aria-label="Dismiss success notification"
                            class="shrink-0 rounded-lg p-1 text-emerald-600 transition hover:bg-emerald-100"
                        >

                            <svg
                                class="h-4 w-4"
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

                @endif



                {{-- =================================================
                     ERROR FLASH MESSAGE
                ================================================== --}}

                @if(session('error'))

                    <div
                        x-data="{ visible: true }"
                        x-show="visible"
                        x-transition.opacity
                        role="alert"
                        class="flex items-start justify-between gap-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-4 shadow-sm"
                    >

                        <div class="flex items-start gap-3">

                            <svg
                                class="mt-0.5 h-5 w-5 shrink-0 text-rose-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                stroke-width="2"
                            >
                                <circle cx="12" cy="12" r="9"/>

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 8v4M12 16h.01"
                                />
                            </svg>

                            <div>

                                <p class="text-sm font-bold text-rose-800">
                                    Something went wrong
                                </p>

                                <p class="mt-1 text-sm leading-6 text-rose-700">
                                    {{ session('error') }}
                                </p>

                            </div>

                        </div>


                        <button
                            type="button"
                            x-on:click="visible = false"
                            aria-label="Dismiss error notification"
                            class="shrink-0 rounded-lg p-1 text-rose-600 transition hover:bg-rose-100"
                        >

                            <svg
                                class="h-4 w-4"
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

                @endif



                {{-- =================================================
                     PAGE SLOT
                ================================================== --}}

                <div class="min-w-0 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6 lg:p-8">

                    {{ $slot }}

                </div>

            </div>

        </main>



        {{-- =====================================================
             FOOTER
        ====================================================== --}}

        <footer class="shrink-0 border-t border-slate-200 bg-white px-4 py-5 sm:px-6 lg:px-8">

            <div class="mx-auto flex max-w-7xl flex-col gap-2 text-xs text-slate-400 sm:flex-row sm:items-center sm:justify-between">

                <p>
                    © {{ date('Y') }} UniTicket. All rights reserved.
                </p>

                <p>
                    University Staff Support Portal
                </p>

            </div>

        </footer>

    </div>

</div>


@stack('scripts')

</body>
</html>
