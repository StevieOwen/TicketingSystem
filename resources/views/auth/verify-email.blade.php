<x-authLayout>

        <!-- Verification Card -->
        <div class="mx-auto w-full max-w-md rounded-2xl border border-slate-200 bg-white p-6 shadow-xl shadow-slate-200/60 sm:p-9">

            <!-- Email Icon -->
            <div class="mb-6 flex justify-center">

                <div class="relative flex h-20 w-20 items-center justify-center rounded-full bg-amber-100">

                    <svg
                        class="h-10 w-10 text-amber-600"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.5"
                    >
                        <rect
                            x="3"
                            y="5"
                            width="18"
                            height="14"
                            rx="2"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m3 7 9 6 9-6"
                        />
                    </svg>

                    <!-- Decorative Notification Dot -->
                    <span class="absolute right-1 top-1 flex h-5 w-5 items-center justify-center rounded-full border-[3px] border-white bg-sky-500"></span>

                </div>

            </div>

            <!-- Heading -->
            <div class="mb-7 text-center">

                <h2 class="text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">
                    Verify Your Email Address
                </h2>

                <p class="mt-4 text-sm leading-7 text-slate-600">
                    Thanks for signing up! Before getting started,
                    could you verify your email address by clicking
                    on the link we just emailed to you?
                    If you didn't receive the email, we will gladly
                    send you another.
                </p>

            </div>

            <!-- Current User Email -->
            @auth
                <div class="mb-6 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-center">

                    <p class="mb-1 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                        Verification email sent to
                    </p>

                    <p class="break-all text-sm font-semibold text-indigo-950">
                        {{ auth()->user()->email }}
                    </p>

                </div>
            @endauth

            <!-- Success Status Alert -->
            @if (session('status') == 'verification-link-sent')

                <div
                    role="status"
                    aria-live="polite"
                    class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4"
                >

                    <div class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-emerald-100">

                        <svg
                            class="h-3.5 w-3.5 text-emerald-600"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            stroke-width="2.5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M5 13l4 4L19 7"
                            />
                        </svg>

                    </div>

                    <p class="text-xs font-medium leading-relaxed text-emerald-700">
                        A new verification link has been sent to the email
                        address you provided during registration.
                    </p>

                </div>

            @endif

            <!-- Resend Verification Email -->
            <form
                method="POST"
                action="{{ route('verification.send') }}"
                x-data="{ loading: false }"
                x-on:submit="if (loading) { $event.preventDefault(); return; } loading = true"
            >

                @csrf

                <button
                    type="submit"
                    x-bind:disabled="loading"
                    x-bind:aria-busy="loading.toString()"
                    class="flex w-full items-center justify-center gap-3 rounded-xl bg-sky-600 px-4 py-3.5 text-sm font-semibold text-white shadow-sm shadow-sky-600/20 transition-all duration-200 hover:-translate-y-0.5 hover:bg-sky-700 hover:shadow-md hover:shadow-sky-600/20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600 active:translate-y-0 disabled:cursor-not-allowed disabled:opacity-65 disabled:hover:translate-y-0"
                >

                    <!-- Normal State -->
                    <span
                        x-show="!loading"
                        class="flex items-center justify-center gap-2"
                    >

                        <svg
                            class="h-4 w-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4 4v6h6M20 20v-6h-6"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M5.5 15A7 7 0 0 0 18 17M18.5 9A7 7 0 0 0 6 7"
                            />
                        </svg>

                        Resend Verification Email

                    </span>

                    <!-- Loading State -->
                    <span
                        x-cloak
                        x-show="loading"
                        role="status"
                        class="flex items-center justify-center gap-3"
                    >

                        <svg
                            class="h-5 w-5 animate-spin text-white"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <circle
                                class="opacity-25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"
                            />

                            <path
                                class="opacity-90"
                                fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4Z"
                            />
                        </svg>

                        Sending verification email...

                    </span>

                </button>

            </form>

            <!-- Secondary Action -->
            <div class="mt-5 text-center">

                <p class="mb-3 text-xs text-slate-400">
                    Registered with the wrong email address?
                </p>

                <!-- Logout -->
                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >

                    @csrf

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-lg px-4 py-2 text-sm font-semibold text-slate-600 transition-colors duration-200 hover:bg-slate-100 hover:text-slate-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600"
                    >

                        <svg
                            class="h-4 w-4"
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

                        Log Out

                    </button>

                </form>

            </div>

            <!-- Security Note -->
            <div class="mt-7 border-t border-slate-100 pt-6">

                <div class="flex items-start gap-3">

                    <svg
                        class="mt-0.5 h-4 w-4 shrink-0 text-slate-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 3 4 7v5c0 5 3.4 8 8 9 4.6-1 8-4 8-9V7l-8-4Z"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 12l2 2 4-4"
                        />
                    </svg>

                    <p class="text-xs leading-relaxed text-slate-400">
                        Email verification helps us keep your student
                        account secure and ensures important ticket
                        notifications reach the correct inbox.
                    </p>

                </div>

            </div>

        </div>
</x-authLayout>
