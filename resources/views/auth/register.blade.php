<x-authLayout>

    <!-- Registration Card -->
    <div
        class="w-full max-w-[560px] rounded-2xl border border-slate-200 bg-white p-6 shadow-xl shadow-slate-200/60 sm:p-9 lg:p-10"
        x-data="studentRegistration()"
    >

        <!-- Card Header -->
        <div class="mb-8">

            <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-sky-100 bg-sky-50 px-3 py-1.5">

                <span class="h-2 w-2 rounded-full bg-sky-500"></span>

                <span class="text-[11px] font-bold uppercase tracking-wider text-sky-700">
                    Student Registration
                </span>

            </div>

            <h2 class="text-2xl font-bold tracking-tight text-indigo-950 sm:text-[28px]">
                Create your account
            </h2>

            <p class="mt-2 text-sm leading-relaxed text-slate-500">
                Join your university support portal to submit tickets,
                track requests, and receive timely assistance.
            </p>

        </div>

        <!-- Registration Form -->
        <form
            method="POST"
            action="{{ route('register.store') }}"
            x-on:submit="submitForm($event)"
            class="space-y-5"
        >

            @csrf

            <!-- Full Name -->
            <div>

                <label
                    for="name"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    Full Name <span class="text-rose-500">*</span>
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="e.g. Jean Paul Habimana"
                    autocomplete="name"
                    required
                    autofocus
                    @error('name') aria-invalid="true" aria-describedby="name-error" @enderror
                    class="block w-full rounded-xl border bg-white px-4 py-3.5 text-sm text-slate-900 outline-none transition duration-200 placeholder:text-slate-400 focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10
                    {{ $errors->has('name') ? 'border-rose-300' : 'border-slate-200 hover:border-slate-300' }}"
                >

                @error('name')
                    <p id="name-error" class="mt-1 text-xs font-medium text-rose-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <!-- Email -->
            <div>

                <label
                    for="email"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    Email Address <span class="text-rose-500">*</span>
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="e.g. student@university.ac.rw"
                    autocomplete="email"
                    required
                    @error('email') aria-invalid="true" aria-describedby="email-error" @enderror
                    class="block w-full rounded-xl border bg-white px-4 py-3.5 text-sm text-slate-900 outline-none transition duration-200 placeholder:text-slate-400 focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10
                    {{ $errors->has('email') ? 'border-rose-300' : 'border-slate-200 hover:border-slate-300' }}"
                >

                @error('email')
                    <p id="email-error" class="mt-1 text-xs font-medium text-rose-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <!-- Department -->
            <div>

                <label
                    for="department"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    Department <span class="text-rose-500">*</span>
                </label>

                <div class="relative">

                    <select
                        id="department"
                        name="department"
                        required
                        @error('department') aria-invalid="true" aria-describedby="department-error" @enderror
                        class="block w-full appearance-none rounded-xl border bg-white px-4 py-3.5 pr-11 text-sm text-slate-700 outline-none transition duration-200 focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10
                        {{ $errors->has('department') ? 'border-rose-300' : 'border-slate-200 hover:border-slate-300' }}"
                    >

                        <option value="" disabled {{ old('department') ? '' : 'selected' }}>
                            Select your department
                        </option>

                        @foreach ([
                            'Computer Science',
                            'Information Technology',
                            'Business Information Technology',
                            'Software Engineering',
                            'Networks & Communication'
                        ] as $department)

                            <option
                                value="{{ $department }}"
                                {{ old('department') === $department ? 'selected' : '' }}
                            >
                                {{ $department }}
                            </option>

                        @endforeach

                    </select>

                    <!-- Dropdown Arrow -->
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4">

                        <svg
                            class="h-4 w-4 text-slate-400"
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

                    </div>

                </div>

                @error('department')
                    <p id="department-error" class="mt-1 text-xs font-medium text-rose-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <!-- Registration Number -->
            <div>

                <label
                    for="regnumber"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    Registration Number <span class="text-rose-500">*</span>
                </label>

                <input
                    type="text"
                    id="regnumber"
                    name="regnumber"
                    value="{{ old('regnumber') }}"
                    placeholder="e.g. BIT-2024-0089"
                    autocomplete="off"
                    spellcheck="false"
                    required
                    @error('regnumber') aria-invalid="true" aria-describedby="regnumber-error" @enderror
                    class="block w-full rounded-xl border bg-white px-4 py-3.5 font-mono text-sm tracking-wide text-slate-900 outline-none transition duration-200 placeholder:text-slate-400 focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10
                    {{ $errors->has('regnumber') ? 'border-rose-300' : 'border-slate-200 hover:border-slate-300' }}"
                >

                <p class="mt-2 text-xs leading-relaxed text-slate-400">
                    Enter the registration number assigned by your university.
                </p>

                @error('regnumber')
                    <p id="regnumber-error" class="mt-1 text-xs font-medium text-rose-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <!-- Divider -->
            <div class="flex items-center gap-4 py-2">

                <div class="h-px flex-1 bg-slate-100"></div>

                <span class="text-[11px] font-bold uppercase tracking-widest text-slate-400">
                    Account Security
                </span>

                <div class="h-px flex-1 bg-slate-100"></div>

            </div>

            <!-- Password -->
            <div>

                <label
                    for="password"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    Password <span class="text-rose-500">*</span>
                </label>

                <div class="relative">

                    <input
                        id="password"
                        name="password"
                        x-model="password"
                        x-bind:type="showPassword ? 'text' : 'password'"
                        placeholder="••••••••"
                        autocomplete="new-password"
                        minlength="8"
                        required
                        @error('password') aria-invalid="true" aria-describedby="password-error" @enderror
                        class="block w-full rounded-xl border bg-white px-4 py-3.5 pr-12 text-sm text-slate-900 outline-none transition duration-200 placeholder:text-slate-400 focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10
                        {{ $errors->has('password') ? 'border-rose-300' : 'border-slate-200 hover:border-slate-300' }}"
                    >

                    <!-- Password Visibility -->
                    <button
                        type="button"
                        x-on:click="showPassword = !showPassword"
                        x-bind:aria-label="showPassword ? 'Hide password' : 'Show password'"
                        x-bind:aria-pressed="showPassword.toString()"
                        class="absolute inset-y-0 right-0 flex items-center rounded-r-xl px-4 text-slate-400 transition hover:text-sky-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-sky-500"
                    >

                        <svg
                            x-show="!showPassword"
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

                        <svg
                            x-cloak
                            x-show="showPassword"
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 3l18 18M10.6 6.1A10.8 10.8 0 0 1 12 6c6.25 0 9.75 6 9.75 6a15 15 0 0 1-3.2 3.7M6.2 6.2C3.6 8 2.25 12 2.25 12s3.5 6 9.75 6c1.3 0 2.5-.3 3.6-.7"
                            />
                        </svg>

                    </button>

                </div>

                <p class="mt-2 text-xs text-slate-400">
                    Use at least 8 characters for your password.
                </p>

                @error('password')
                    <p id="password-error" class="mt-1 text-xs font-medium text-rose-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <!-- Confirm Password -->
            <div>

                <label
                    for="password_confirmation"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    Confirm Password <span class="text-rose-500">*</span>
                </label>

                <div class="relative">

                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        x-model="passwordConfirmation"
                        x-bind:type="showConfirmation ? 'text' : 'password'"
                        placeholder="••••••••"
                        autocomplete="new-password"
                        minlength="8"
                        required
                        @error('password_confirmation') aria-invalid="true" aria-describedby="confirmation-error" @enderror
                        class="block w-full rounded-xl border bg-white px-4 py-3.5 pr-12 text-sm text-slate-900 outline-none transition duration-200 placeholder:text-slate-400 focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10
                        {{ $errors->has('password_confirmation') ? 'border-rose-300' : 'border-slate-200 hover:border-slate-300' }}"
                        x-bind:class="{
                            'border-emerald-400 focus:border-emerald-500 focus:ring-emerald-500/10': passwordConfirmation.length > 0 && passwordsMatch,
                            'border-rose-300 focus:border-rose-500 focus:ring-rose-500/10': passwordConfirmation.length > 0 && !passwordsMatch
                        }"
                    >

                    <!-- Confirmation Visibility -->
                    <button
                        type="button"
                        x-on:click="showConfirmation = !showConfirmation"
                        x-bind:aria-label="showConfirmation ? 'Hide confirmation' : 'Show confirmation'"
                        x-bind:aria-pressed="showConfirmation.toString()"
                        class="absolute inset-y-0 right-0 flex items-center rounded-r-xl px-4 text-slate-400 transition hover:text-sky-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-sky-500"
                    >

                        <svg
                            x-show="!showConfirmation"
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

                        <svg
                            x-cloak
                            x-show="showConfirmation"
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 3l18 18M10.6 6.1A10.8 10.8 0 0 1 12 6c6.25 0 9.75 6 9.75 6a15 15 0 0 1-3.2 3.7M6.2 6.2C3.6 8 2.25 12 2.25 12s3.5 6 9.75 6c1.3 0 2.5-.3 3.6-.7"
                            />
                        </svg>

                    </button>

                </div>

                <!-- Live Password Match Indicator -->
                <div
                    x-cloak
                    x-show="passwordConfirmation.length > 0"
                    x-transition.opacity.duration.200ms
                    aria-live="polite"
                    class="mt-2 flex items-center gap-2 text-xs font-medium"
                    x-bind:class="passwordsMatch ? 'text-emerald-600' : 'text-rose-600'"
                >

                    <!-- Match Icon -->
                    <svg
                        x-show="passwordsMatch"
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>

                    <!-- Mismatch Icon -->
                    <svg
                        x-show="!passwordsMatch"
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

                    <span
                        x-text="passwordsMatch
                            ? 'Passwords match'
                            : 'Passwords do not match'"
                    ></span>

                </div>

                @error('password_confirmation')
                    <p id="confirmation-error" class="mt-1 text-xs font-medium text-rose-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <!-- Submit Button -->
            <div class="pt-3">

                <button
                    type="submit"
                    x-bind:disabled="loading"
                    x-bind:aria-busy="loading.toString()"
                    class="group flex w-full items-center justify-center gap-3 rounded-xl bg-sky-600 px-5 py-4 text-sm font-bold text-white shadow-md shadow-sky-600/20 transition-all duration-200 hover:-translate-y-0.5 hover:bg-sky-700 hover:shadow-lg hover:shadow-sky-600/25 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600 active:translate-y-0 disabled:cursor-not-allowed disabled:opacity-65 disabled:hover:translate-y-0"
                >

                    <!-- Normal State -->
                    <span
                        x-show="!loading"
                        class="flex items-center justify-center gap-2"
                    >

                        Create Student Account

                        <svg
                            class="h-4 w-4 transition-transform group-hover:translate-x-1"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M5 12h14m-6-6 6 6-6 6"
                            />
                        </svg>

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

                        <span>Registering Account...</span>

                    </span>

                </button>

                <p class="mt-4 text-center text-xs leading-relaxed text-slate-400">
                    By creating an account, you agree to use the university
                    ticketing portal responsibly.
                </p>

            </div>

        </form>

        <!-- Sign In Link -->
        <div class="mt-8 border-t border-slate-100 pt-7 text-center">

            <p class="text-sm text-slate-500">

                Already have an account?

                <a
                    href="{{ route('login') }}"
                    class="ml-1 font-bold text-sky-600 transition hover:text-sky-700 hover:underline focus-visible:rounded focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600"
                >
                    Sign in
                </a>

            </p>

        </div>

    </div>

    



<!-- Alpine.js Component -->
<script>
    document.addEventListener('alpine:init', () => {

        Alpine.data('studentRegistration', () => ({

            password: '',
            passwordConfirmation: '',

            showPassword: false,
            showConfirmation: false,

            loading: false,

            get passwordsMatch() {
                return this.password.length > 0
                    && this.password === this.passwordConfirmation;
            },

            submitForm(event) {

                // Prevent duplicate submissions.
                if (this.loading) {
                    event.preventDefault();
                    return;
                }

                // Validate password confirmation.
                if (!this.passwordsMatch) {

                    event.preventDefault();

                    const confirmation = document.getElementById(
                        'password_confirmation'
                    );

                    confirmation.setCustomValidity(
                        'Passwords do not match.'
                    );

                    confirmation.reportValidity();
                    confirmation.focus();

                    return;
                }

                // Clear any previous custom validation error.
                document.getElementById(
                    'password_confirmation'
                ).setCustomValidity('');

                // Respect native browser validation.
                if (!event.target.checkValidity()) {

                    event.preventDefault();
                    event.target.reportValidity();

                    return;
                }

                // Activate loading state.
                // Normal POST submission continues to Laravel.
                this.loading = true;

            },

            init() {

                this.$watch('password', () => {
                    this.clearConfirmationError();
                });

                this.$watch('passwordConfirmation', () => {
                    this.clearConfirmationError();
                });

                // Restore button state if the browser restores
                // the page from its back-forward cache.
                window.addEventListener('pageshow', () => {
                    this.loading = false;
                });

            },

            clearConfirmationError() {

                const confirmation = document.getElementById(
                    'password_confirmation'
                );

                if (confirmation) {
                    confirmation.setCustomValidity('');
                }

            }

        }));

    });
</script>

</x-authLayout>