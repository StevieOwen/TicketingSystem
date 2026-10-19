
<x-authLayout>

        <!-- Forgot Password Card -->
        <div
            class="mx-auto w-full max-w-md rounded-2xl border border-slate-200 bg-white p-6 shadow-xl shadow-slate-200/60 sm:p-9"
            x-data="forgotPasswordForm()"
        >

            <!-- Icon -->
            <div class="mb-7 flex justify-center">

                <div class="flex h-20 w-20 items-center justify-center rounded-full bg-sky-50">

                    <svg
                        class="h-10 w-10 text-sky-600"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.5"
                    >
                        <rect
                            x="3"
                            y="10"
                            width="18"
                            height="11"
                            rx="2"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M7 10V7a5 5 0 0 1 10 0v3M12 14v3"
                        />
                    </svg>

                </div>

            </div>

            <!-- Heading -->
            <div class="mb-7 text-center">

                <h2 class="text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">
                    Forgot your password?
                </h2>

                <p class="mt-3 text-sm leading-7 text-slate-600">
                    No problem. Just let us know your email address
                    and we will email you a password reset link
                    that will allow you to choose a new one.
                </p>

            </div>

            <!-- Session Status -->
            @if (session('status'))

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
                        {{ session('status') }}
                    </p>

                </div>

            @endif

            <!-- Password Reset Form -->
            <form
                method="POST"
                action="{{ route('password.email') }}"
                x-on:submit="submitForm($event)"
                x-on:input="resetState()"
                class="space-y-6"
            >

                @csrf

                <!-- Email -->
                <div>

                    <label
                        for="email"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Email Address
                        <span class="text-rose-500">*</span>
                    </label>

                    <div class="relative">

                        <!-- Email Icon -->
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">

                            <svg
                                class="h-5 w-5 text-slate-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                stroke-width="1.7"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3 8l9 6 9-6M5 5h14a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z"
                                />
                            </svg>

                        </div>

                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            placeholder="student@university.ac.rw"
                            autocomplete="email"
                            required
                            autofocus
                            @error('email') aria-invalid="true" aria-describedby="email-error" @enderror
                            class="block w-full rounded-xl border bg-white py-3.5 pl-12 pr-4 text-sm text-slate-900 outline-none transition duration-200 placeholder:text-slate-400 focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10
                            {{ $errors->has('email')
                                ? 'border-rose-300'
                                : 'border-slate-200 hover:border-slate-300' }}"
                        >

                    </div>

                    @error('email')
                        <p id="email-error" class="mt-1 text-xs font-medium text-rose-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    x-bind:disabled="loading"
                    x-bind:aria-busy="loading.toString()"
                    class="group flex w-full items-center justify-center gap-3 rounded-xl bg-sky-600 px-4 py-3.5 text-sm font-semibold text-white shadow-sm shadow-sky-600/20 transition-all duration-200 hover:-translate-y-0.5 hover:bg-sky-700 hover:shadow-md hover:shadow-sky-600/20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600 active:translate-y-0 disabled:cursor-not-allowed disabled:opacity-65 disabled:hover:translate-y-0"
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
                                d="M3 8l9 6 9-6M5 5h14a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z"
                            />
                        </svg>

                        Email Password Reset Link

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

                        Sending reset link...

                    </span>

                </button>

            </form>

            <!-- Back to Login -->
            <div class="mt-7 border-t border-slate-100 pt-6 text-center">

                <a
                    href="{{ route('login') }}"
                    class="group inline-flex items-center justify-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold text-slate-600 transition-colors duration-200 hover:bg-slate-50 hover:text-sky-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600"
                >

                    <svg
                        class="h-4 w-4 transition-transform duration-200 group-hover:-translate-x-1"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19 12H5m6 6-6-6 6-6"
                        />
                    </svg>

                    Back to login

                </a>

            </div>

            <!-- Help Note -->
            <div class="mt-5 rounded-xl bg-slate-50 px-4 py-3">

                <p class="text-center text-xs leading-relaxed text-slate-500">
                    Please check your spam or junk folder if you don't
                    receive the password reset email in your inbox.
                </p>

            </div>

        </div>

        

    <!-- Alpine.js Logic -->
    <script>
        document.addEventListener('alpine:init', () => {

            Alpine.data('forgotPasswordForm', () => ({

                loading: false,

                submitForm(event) {

                    // Prevent duplicate form submissions.
                    if (this.loading) {
                        event.preventDefault();
                        return;
                    }

                    // Respect native browser validation.
                    if (!event.target.checkValidity()) {

                        event.preventDefault();
                        event.target.reportValidity();

                        return;
                    }

                    // Show loading indicator.
                    // The browser continues with the normal POST request.
                    this.loading = true;

                },

                resetState() {
                    this.loading = false;
                },

                init() {

                    // Restore the button when navigating back
                    // using the browser's back-forward cache.
                    window.addEventListener('pageshow', () => {
                        this.loading = false;
                    });

                }

            }));

        });
    </script>

</x-authLayout>