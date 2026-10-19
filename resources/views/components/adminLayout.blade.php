<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') | UniTicket</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Laravel Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }
        body {
            font-family: 'Inter', sans-serif;
        }
        .sidebar-scroll::-webkit-scrollbar {
            width: 5px;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.25);
            border-radius: 10px;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-slate-50 text-slate-700 antialiased">

    <div
        x-data="{
            sidebarOpen: false,
            profileOpen: false
        }"
        x-on:keydown.escape.window="
            sidebarOpen = false;
            profileOpen = false;
        "
        class="min-h-screen bg-slate-50"
    >

        <!-- =====================================================
             MOBILE SIDEBAR OVERLAY
        ====================================================== -->
        <div
            x-cloak
            x-show="sidebarOpen"
            x-transition.opacity.duration.200ms
            x-on:click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-indigo-950/60 backdrop-blur-sm lg:hidden"
            aria-hidden="true"
        ></div>


        <!-- =====================================================
             SIDEBAR
        ====================================================== -->
        <aside
            id="admin-sidebar"
            x-bind:class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="fixed inset-y-0 left-0 z-50 flex w-72 flex-col bg-indigo-950 text-slate-100 shadow-2xl transition-transform duration-300 ease-in-out lg:translate-x-0 lg:shadow-none"
            aria-label="Admin navigation"
        >

            <!-- Sidebar Branding -->
            <div class="flex h-20 shrink-0 items-center justify-between border-b border-white/10 px-6">
                <a href="{{ route('admin.overview') }}" class="flex min-w-0 items-center gap-3">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-sky-600 shadow-lg shadow-sky-950/20">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3 2 8l10 5 10-5-10-5ZM5 10v6c0 2.5 3.1 4.5 7 4.5s7-2 7-4.5v-6M22 8v7"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <h1 class="truncate text-lg font-extrabold tracking-tight text-white">UniTicket</h1>
                        <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-sky-300">Admin Portal</p>
                    </div>
                </a>

                <button
                    type="button"
                    x-on:click="sidebarOpen = false"
                    aria-label="Close sidebar"
                    class="rounded-lg p-2 text-slate-300 transition hover:bg-white/10 hover:text-white lg:hidden"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>


            <!-- Sidebar Navigation -->
            <nav class="sidebar-scroll flex-1 space-y-1.5 overflow-y-auto px-4 py-6">
                <p class="mb-4 px-4 text-[10px] font-bold uppercase tracking-[0.2em] text-indigo-300/60">
                    Main Navigation
                </p>

                <!-- Overview -->
                <a href="{{ route('admin.overview') }}"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm transition-all duration-200
                    {{ request()->routeIs('admin.overview') ? 'bg-sky-600 font-semibold text-white shadow-sm shadow-sky-900/30' : 'text-slate-300 hover:bg-indigo-900/50 hover:text-white' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
                    </svg>
                    <span class="flex-1">Overview</span>
                </a>

                <!-- Staff Management -->
                <a href="{{ route('admin.staffs_index') }}"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm transition-all duration-200
                    {{ request()->routeIs('admin.staffs_*') ? 'bg-sky-600 font-semibold text-white shadow-sm shadow-sky-900/30' : 'text-slate-300 hover:bg-indigo-900/50 hover:text-white' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    <span class="flex-1">Staff Management</span>
                </a>

                <!-- Student Directory -->
                <a href="{{ route('admin.students_index') }}"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm transition-all duration-200
                    {{ request()->routeIs('admin.students_*') ? 'bg-sky-600 font-semibold text-white shadow-sm shadow-sky-900/30' : 'text-slate-300 hover:bg-indigo-900/50 hover:text-white' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2 8 10-5 10 5-10 5L2 8ZM5 10v6c0 2.5 3.1 4.5 7 4.5s7-2 7-4.5v-6M22 8v7"/>
                    </svg>
                    <span class="flex-1">Student Directory</span>
                </a>

                <!-- Global Tickets -->
                <a href="{{ route('admin.tickets_index') }}"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm transition-all duration-200
                    {{ request()->routeIs('admin.tickets_*') ? 'bg-sky-600 font-semibold text-white shadow-sm shadow-sky-900/30' : 'text-slate-300 hover:bg-indigo-900/50 hover:text-white' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 5h16a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-3a2 2 0 0 0 0-4V7a2 2 0 0 1 2-2Z"/>
                    </svg>
                    <span class="flex-1">Global Tickets</span>
                </a>

                <div class="px-4 pb-3 pt-7">
                    <div class="mb-5 h-px bg-white/10"></div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-indigo-300/60">Administration</p>
                </div>

                <!-- Settings & Logs -->
                <a href="{{ route('admin.settings_logs') }}"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm transition-all duration-200
                    {{ request()->routeIs('admin.settings_logs') ? 'bg-sky-600 font-semibold text-white shadow-sm shadow-sky-900/30' : 'text-slate-300 hover:bg-indigo-900/50 hover:text-white' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Z"/>
                    </svg>
                    <span class="flex-1">Settings & Logs</span>
                </a>
            </nav>

            <!-- Sidebar Bottom -->
            <div class="shrink-0 border-t border-white/10 p-4">
                <div class="rounded-xl bg-indigo-900/60 p-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-sky-500/15 text-sky-300">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3 4 7v5c0 5 3.4 8 8 9 4.6-1 8-4 8-9V7l-8-4Z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs font-semibold text-white">Admin Workspace</p>
                            <p class="mt-0.5 text-[11px] text-indigo-200/70">University Ticketing</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>


        <!-- =====================================================
             MAIN WRAPPER (Flex layout with left padding for sidebar)
        ====================================================== -->
        <div class="flex min-h-screen flex-col lg:pl-72">

            <!-- TOP NAVBAR -->
            <header class="sticky top-0 z-35 border-b border-slate-200/80 bg-white/95 shadow-sm backdrop-blur-md">
                <div class="flex h-20 items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
                    
                    <div class="flex min-w-0 items-center gap-4">
                        <button
                            type="button"
                            x-on:click="sidebarOpen = true; profileOpen = false"
                            class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 hover:bg-sky-50 lg:hidden"
                        >
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>

                        <div class="min-w-0">
                            <p class="hidden text-[11px] font-semibold uppercase tracking-widest text-slate-400 sm:block">
                                Admin Workspace
                            </p>
                            <!-- <h2 class="truncate text-lg font-bold tracking-tight text-indigo-950 sm:text-xl">
                                @yield('header', 'Dashboard Overview')
                            </h2> -->
                        </div>
                    </div>

                    <!-- Right Section (Profile) -->
                    <div class="flex shrink-0 items-center gap-3 sm:gap-5">
                        <div class="hidden h-8 w-px bg-slate-200 sm:block"></div>

                        <div class="relative" x-on:click.outside="profileOpen = false">
                            <button
                                type="button"
                                x-on:click="profileOpen = !profileOpen"
                                class="flex items-center gap-3 rounded-xl p-1.5 transition hover:bg-slate-50"
                            >
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-indigo-950 text-sm font-bold uppercase text-white shadow-sm">
                                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                                </div>
                                <div class="hidden max-w-44 text-left sm:block">
                                    <p class="truncate text-sm font-bold text-slate-800">{{ auth()->user()->name ?? 'Administrator' }}</p>
                                    <p class="truncate text-xs text-slate-400">{{ auth()->user()->email ?? '' }}</p>
                                </div>
                                <svg class="hidden h-4 w-4 text-slate-400 transition-transform duration-200 sm:block" x-bind:class="profileOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/>
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div
                                id="admin-profile-menu"
                                x-cloak
                                x-show="profileOpen"
                                x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                class="absolute right-0 z-50 mt-3 w-64 origin-top-right rounded-2xl border border-slate-200 bg-white p-2 shadow-xl"
                            >
                                <div class="border-b border-slate-100 px-3 py-3">
                                    <p class="text-xs font-medium text-slate-400">Signed in as</p>
                                    <p class="mt-1 truncate text-sm font-bold text-indigo-950">{{ auth()->user()->name ?? '' }}</p>
                                    <p class="mt-0.5 truncate text-xs text-slate-500">{{ auth()->user()->email ?? '' }}</p>
                                </div>
                                <div class="mt-2 border-t border-slate-100 pt-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-left text-sm font-semibold text-rose-600 hover:bg-rose-50">
                                            Log Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </header>


            <!-- =================================================
                 MAIN CONTENT AREA
            ================================================== -->
            <main class="flex-1">
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </main>


            <!-- Footer -->
            <footer class="border-t border-slate-200/80 bg-white px-4 py-5 sm:px-6 lg:px-8">
                <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-2 text-center sm:flex-row sm:text-left">
                    <p class="text-xs text-slate-400">&copy; {{ date('Y') }} UniTicket. All rights reserved.</p>
                    <p class="text-xs text-slate-400">University Ticketing Management System</p>
                </div>
            </footer>

        </div>

    </div>

</body>
</html>