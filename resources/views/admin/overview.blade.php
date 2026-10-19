<x-adminLayout>

<div class="mx-auto max-w-7xl space-y-6">

    <!-- =====================================================
         PAGE HEADER
    ====================================================== -->
    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold tracking-tight text-indigo-950 sm:text-3xl">
                Dashboard Overview
            </h1>

            <p class="mt-2 text-sm leading-relaxed text-slate-500">
                Welcome back! Here is a summary of platform activity and user metrics.
            </p>
        </div>

        <!-- Overview Indicator -->
        <div class="mt-2 inline-flex w-fit items-center gap-2 rounded-full border border-sky-100 bg-sky-50 px-3 py-2 sm:mt-0">

            <span class="h-2 w-2 rounded-full bg-sky-500"></span>

            <span class="text-xs font-semibold text-sky-700">
                Platform Overview
            </span>

        </div>

    </div>


    <!-- =====================================================
         STATISTICS CARDS
    ====================================================== -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">

        <!-- TOTAL STAFF MEMBERS -->
        <div class="group relative overflow-hidden rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:border-indigo-200 hover:shadow-md">

            <!-- Decorative Accent -->
            <div class="absolute right-0 top-0 h-24 w-24 translate-x-8 -translate-y-8 rounded-full bg-indigo-50/70 transition-transform duration-300 group-hover:scale-125"></div>

            <div class="relative">

                <!-- Icon -->
                <div class="mb-6 flex items-start justify-between">

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">

                        <svg
                            class="h-6 w-6"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"
                            />
                        </svg>

                    </div>

                    <!-- Small Indicator -->
                    <span class="rounded-lg bg-indigo-50 px-2.5 py-1 text-[11px] font-semibold text-indigo-600">
                        Staff
                    </span>

                </div>

                <!-- Label -->
                <p class="text-sm font-medium text-slate-500">
                    Total Staff Members
                </p>

                <!-- Value -->
                <h3 class="mt-2 font-mono text-3xl font-extrabold tracking-tight text-indigo-950 sm:text-4xl">
                    {{ number_format($count_staffs) }}
                </h3>

                <!-- Footer -->
                <div class="mt-5 flex items-center gap-2 border-t border-slate-100 pt-4">

                    <span class="flex h-2 w-2 rounded-full bg-indigo-500"></span>

                    <p class="text-xs font-medium text-slate-400">
                        Registered staff accounts
                    </p>

                </div>

            </div>

        </div>


        <!-- TOTAL REGISTERED STUDENTS -->
        <div class="group relative overflow-hidden rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:border-sky-200 hover:shadow-md">

            <!-- Decorative Accent -->
            <div class="absolute right-0 top-0 h-24 w-24 translate-x-8 -translate-y-8 rounded-full bg-sky-50/70 transition-transform duration-300 group-hover:scale-125"></div>

            <div class="relative">

                <!-- Icon -->
                <div class="mb-6 flex items-start justify-between">

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-sky-50 text-sky-600">

                        <svg
                            class="h-6 w-6"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m2 8 10-5 10 5-10 5L2 8Z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M5 10v6c0 2.5 3.1 4.5 7 4.5s7-2 7-4.5v-6M22 8v7"
                            />
                        </svg>

                    </div>

                    <!-- Small Indicator -->
                    <span class="rounded-lg bg-sky-50 px-2.5 py-1 text-[11px] font-semibold text-sky-600">
                        Students
                    </span>

                </div>

                <!-- Label -->
                <p class="text-sm font-medium text-slate-500">
                    Registered Students
                </p>

                <!-- Value -->
                <h3 class="mt-2 font-mono text-3xl font-extrabold tracking-tight text-indigo-950 sm:text-4xl">
                    {{ number_format($count_students) }}
                </h3>

                <!-- Footer -->
                <div class="mt-5 flex items-center gap-2 border-t border-slate-100 pt-4">

                    <span class="flex h-2 w-2 rounded-full bg-sky-500"></span>

                    <p class="text-xs font-medium text-slate-400">
                        Student accounts on platform
                    </p>

                </div>

            </div>

        </div>


        <!-- TOTAL SUPPORT TICKETS -->
        <div class="group relative overflow-hidden rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:border-emerald-200 hover:shadow-md">

            <!-- Decorative Accent -->
            <div class="absolute right-0 top-0 h-24 w-24 translate-x-8 -translate-y-8 rounded-full bg-emerald-50/70 transition-transform duration-300 group-hover:scale-125"></div>

            <div class="relative">

                <!-- Icon -->
                <div class="mb-6 flex items-start justify-between">

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">

                        <svg
                            class="h-6 w-6"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
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
                                stroke-linejoin="round"
                                d="M13 5v14"
                            />
                        </svg>

                    </div>

                    <!-- Small Indicator -->
                    <span class="rounded-lg bg-emerald-50 px-2.5 py-1 text-[11px] font-semibold text-emerald-600">
                        Tickets
                    </span>

                </div>

                <!-- Label -->
                <p class="text-sm font-medium text-slate-500">
                    Total Support Tickets
                </p>

                <!-- Value -->
                <h3 class="mt-2 font-mono text-3xl font-extrabold tracking-tight text-indigo-950 sm:text-4xl">
                    {{ number_format($count_tickets->count()) }}
                </h3>

                <!-- Footer -->
                <div class="mt-5 flex items-center gap-2 border-t border-slate-100 pt-4">

                    <span class="flex h-2 w-2 rounded-full bg-emerald-500"></span>

                    <p class="text-xs font-medium text-slate-400">
                        Total tickets submitted
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

</x-adminLayout>