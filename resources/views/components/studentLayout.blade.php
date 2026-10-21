
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Student Portal') | UniTicket</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

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

<div
    x-data="{ sidebarOpen: false, profileOpen: false }"
    x-on:keydown.escape.window="
        sidebarOpen = false;
        profileOpen = false;
    "
    class="min-h-screen"
>

    {{-- =====================================================
         MOBILE SIDEBAR BACKDROP
    ====================================================== --}}
    <div
        x-cloak
        x-show="sidebarOpen"
        x-transition.opacity
        x-on:click="sidebarOpen = false"
        class="fixed inset-0 z-40 bg-indigo-950/60 backdrop-blur-sm lg:hidden"
        aria-hidden="true"
    ></div>


    {{-- =====================================================
         SIDEBAR
    ====================================================== --}}
    <aside
        x-bind:class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-50 flex w-72 flex-col border-r border-slate-200 bg-white shadow-xl transition-transform duration-300 lg:translate-x-0 lg:shadow-none"
    >

        {{-- Branding --}}
        <div class="flex h-20 items-center justify-between border-b border-slate-100 px-6">

            <a href="{{ route('students.overview') }}" class="flex items-center gap-3">

                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-indigo-950 text-white shadow-sm">

                    <svg class="h-6 w-6" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m2 8 10-5 10 5-10 5L2 8ZM5 10v6c0 2.5 3.1 4.5 7 4.5s7-2 7-4.5v-6M22 8v7"/>
                    </svg>

                </div>

                <div>
                    <p class="text-base font-extrabold tracking-tight text-indigo-950">
                        University Portal
                    </p>

                    <p class="text-[11px] font-medium tracking-wide text-sky-600">
                        STUDENT WORKSPACE
                    </p>
                </div>

            </a>

            <button
                type="button"
                x-on:click="sidebarOpen = false"
                aria-label="Close navigation"
                class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 lg:hidden"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2" d="M6 18 18 6M6 6l12 12"/>
                </svg>
            </button>

        </div>


        {{-- Navigation --}}
        <nav aria-label="Student navigation" class="flex-1 space-y-2 overflow-y-auto px-4 py-6">

            <p class="mb-4 px-3 text-[11px] font-bold uppercase tracking-widest text-slate-400">
                Workspace
            </p>

            {{-- My Tickets --}}
            <a
                href="{{ route('students.overview') }}"
                @class([
                    'group flex items-center gap-3 rounded-xl border-l-4 px-4 py-3 text-sm transition-all',
                    'border-sky-600 bg-sky-50 font-bold text-sky-700' =>
                        request()->routeIs('students.overview*'),
                    'border-transparent font-medium text-slate-600 hover:bg-slate-50 hover:text-indigo-950' =>
                        !request()->routeIs('students.overview*'),
                ])
            >

                <svg class="h-5 w-5 shrink-0" fill="none"
                     stroke="currentColor" viewBox="0 0 24 24"
                     stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4 5h16a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-3a2 2 0 0 0 0-4V7a2 2 0 0 1 2-2Z"/>
                    <path stroke-linecap="round" stroke-dasharray="2 3"
                          d="M13 5v14"/>
                </svg>

                <span>My Tickets</span>

                @if(request()->routeIs('students.overview*'))
                    <span class="ml-auto h-2 w-2 rounded-full bg-sky-600"></span>
                @endif

            </a>


            {{-- Account Settings --}}
            <a
                href="{{ route('students.settings') }}"
                @class([
                    'group flex items-center gap-3 rounded-xl border-l-4 px-4 py-3 text-sm transition-all',
                    'border-sky-600 bg-sky-50 font-bold text-sky-700' =>
                        request()->routeIs('students.settings*'),
                    'border-transparent font-medium text-slate-600 hover:bg-slate-50 hover:text-indigo-950' =>
                        !request()->routeIs('students.settings*'),
                ])
            >

                <svg class="h-5 w-5 shrink-0" fill="none"
                     stroke="currentColor" viewBox="0 0 24 24"
                     stroke-width="1.8">
                    <circle cx="12" cy="12" r="3"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06-2 2-.06-.06A1.65 1.65 0 0 0 15.9 18.5a1.65 1.65 0 0 0-1 .92V20h-3v-.58a1.65 1.65 0 0 0-1-.92 1.65 1.65 0 0 0-1.82.33l-.06.06-2-2 .06-.06A1.65 1.65 0 0 0 7.4 15a1.65 1.65 0 0 0-.92-1H6v-3h.48a1.65 1.65 0 0 0 .92-1 1.65 1.65 0 0 0-.33-1.82l-.06-.06 2-2 .06.06A1.65 1.65 0 0 0 10.9 6.5a1.65 1.65 0 0 0 1-.92V5h3v.58a1.65 1.65 0 0 0 1 .92 1.65 1.65 0 0 0 1.82-.33l.06-.06 2 2-.06.06A1.65 1.65 0 0 0 19.4 10a1.65 1.65 0 0 0 .92 1H21v3h-.68a1.65 1.65 0 0 0-.92 1Z"/>
                </svg>

                <span>Account Settings</span>

                @if(request()->routeIs('students.settings*'))
                    <span class="ml-auto h-2 w-2 rounded-full bg-sky-600"></span>
                @endif

            </a>

        </nav>


        {{-- Sidebar User Profile --}}
        <div class="border-t border-slate-100 p-4">

            <div class="flex items-center gap-3 rounded-2xl bg-slate-50 p-3">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-indigo-100 font-bold text-indigo-700">
                    {{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                </div>

                <div class="min-w-0">
                    <p class="truncate text-sm font-bold text-indigo-950">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="truncate font-mono text-[11px] text-slate-500">
                        {{ auth()->user()->regnumber ?? 'Student Account' }}
                    </p>
                </div>

            </div>

        </div>

    </aside>


    {{-- =====================================================
         MAIN APPLICATION AREA
    ====================================================== --}}
    <div class="flex min-h-screen min-w-0 flex-col lg:pl-72">

        {{-- Sticky Topbar --}}
        <header class="sticky top-0 z-30 h-20 border-b border-slate-200 bg-white/95 backdrop-blur-xl">

            <div class="flex h-full items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">

                <div class="flex min-w-0 items-center gap-3">

                    {{-- Mobile Menu --}}
                    <button
                        type="button"
                        x-on:click="sidebarOpen = true"
                        aria-label="Open navigation"
                        aria-controls="student-sidebar"
                        x-bind:aria-expanded="sidebarOpen"
                        class="rounded-xl border border-slate-200 p-2.5 text-indigo-950 hover:bg-slate-50 lg:hidden"
                    >
                        <svg class="h-5 w-5" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24"
                             stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    <div class="min-w-0">

                        <p class="truncate text-sm font-bold text-indigo-950 sm:text-base">
                            @yield('header', 'Student Dashboard')
                        </p>

                        <p class="hidden text-xs text-slate-400 sm:block">
                            University Ticket Management System
                        </p>

                    </div>

                </div>


                {{-- Account Area --}}
                <div class="flex shrink-0 items-center gap-3">

                    <div class="hidden min-w-0 text-right sm:block">

                        <p class="max-w-48 truncate text-sm font-bold text-indigo-950">
                            {{ auth()->user()->name }}
                        </p>

                        <p class="max-w-48 truncate text-xs text-slate-500">
                            {{ auth()->user()->email }}
                        </p>

                    </div>

                    <span class="hidden max-w-40 truncate rounded-lg bg-sky-50 px-3 py-2 font-mono text-xs font-semibold text-sky-700 md:inline-flex">
                        {{ auth()->user()->regnumber ?? 'Student' }}
                    </span>

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-950 text-sm font-bold text-white">
                        {{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                    </div>

                    {{-- Standard POST Logout --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button
                            type="submit"
                            title="Log out"
                            aria-label="Log out"
                            class="inline-flex items-center gap-2 rounded-xl border border-slate-200 px-3 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-600"
                        >

                            <svg class="h-5 w-5" fill="none"
                                 stroke="currentColor" viewBox="0 0 24 24"
                                 stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/>
                            </svg>

                            <span class="hidden xl:inline">Logout</span>

                        </button>
                    </form>

                </div>

            </div>

        </header>


        {{-- Main Content --}}
        <main id="main-content" class="min-w-0 flex-1 px-4 py-6 sm:px-6 lg:px-8 lg:py-8">

            <div class="mx-auto w-full max-w-7xl space-y-6">

                {{-- Success Notification --}}
                @if(session('success'))

                    <div
                        role="status"
                        x-data="{ visible: true }"
                        x-show="visible"
                        class="flex items-start justify-between gap-4 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800"
                    >

                        <p>{{ session('success') }}</p>

                        <button
                            type="button"
                            x-on:click="visible = false"
                            aria-label="Dismiss notification"
                            class="font-bold"
                        >
                            &times;
                        </button>

                    </div>

                @endif

                {{$slot}}

            </div>

        </main>


        {{-- Footer --}}
        <footer class="border-t border-slate-200 bg-white px-4 py-5 sm:px-6 lg:px-8">

            <div class="mx-auto flex max-w-7xl flex-col gap-2 text-xs text-slate-400 sm:flex-row sm:items-center sm:justify-between">

                <p>
                    © {{ date('Y') }} UniTicket. All rights reserved.
                </p>

                <p>
                    University Student Support Portal
                </p>

            </div>

        </footer>

    </div>

</div>

@stack('scripts')

</body>
</html>
