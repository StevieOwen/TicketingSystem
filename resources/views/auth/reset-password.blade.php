
<x-authLayout>

        <!-- Reset Password Card -->
        <div
            class="mx-auto w-full max-w-md rounded-2xl border border-slate-200 bg-white p-6 shadow-xl shadow-slate-200/60 sm:p-9"
            x-data="resetPasswordForm()"
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
            <div class="mb-8 text-center">

                <h2 class="text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">
                    Reset Password
                </h2>

                <p class="mt-2 text-sm leading-relaxed text-slate-600">
                    Enter your new password below to secure your account.
                </p>

            </div>

            <!-- Reset Password Form -->
            <form
                method="POST"
                action="{{ route('password.update') }}"
                x-ref="form"
                x-on:submit="submitForm($event)"
                class="space-y-5"
            >

                @csrf

                <!-- Password Reset Token -->
                <input
                    type="hidden"
                    name="token"
                    value="{{ $request->route('token') }}"
                >

                <!-- Email Address -->
                <div>

                    <label
                        for="email"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Email Address
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
                            value="{{ $request->email ?? old('email') }}"
                            placeholder="student@university.ac.rw"
                            autocomplete="email"
                            required
                            readonly
                            @error('email') aria-invalid="true" aria-describedby="email-error" @enderror
                            class="block w-full cursor-default rounded-xl border bg-slate-50 py-3.5 pl-12 pr-4 text-sm font-medium text-slate-600 outline-none transition placeholder:text-slate-400
                            {{ $errors->has('email') ? 'border-rose-300' : 'border-slate-200' }}"
                        >

                    </div>

                    <p class="mt-2 text-xs text-slate-400">
                        This is the email address associated with your reset request.
                    </p>

                    @error('email')
                        <p id="email-error" class="mt-1 text-xs font-medium text-rose-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                <!-- New Password -->
                <div>

                    <label
                        for="password"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        New Password <span class="text-rose-500">*</span>
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
                            autofocus
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

                            <!-- Show Password -->
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

                            <!-- Hide Password -->
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
                        Your new password must contain at least 8 characters.
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
                        Confirm New Password <span class="text-rose-500">*</span>
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
                            class="absolute inset-y-0 right-0 flex items-center rounded-r-xl px-4 text-slate-400 transition hover:text-sky-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-500"
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

                        <!-- Match -->
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

                        <!-- Mismatch -->
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
                        class="group flex w-full items-center justify-center gap-3 rounded-xl bg-sky-600 px-4 py-3.5 text-sm font-semibold text-white shadow-sm shadow-sky-600/20 transition-all duration-200 hover:-translate-y-0.5 hover:bg-sky-700 hover:shadow-md hover:shadow-sky-600/20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600 active:translate-y-0 disabled:cursor-not-allowed disabled:opacity-65 disabled:hover:translate-y-0"
                    >

                        <!-- Normal State -->
                        <span
                            x-show="!loading"
                            class="flex items-center justify-center gap-2"
                        >

                            Reset Password

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

                            Resetting Password...

                        </span>

                    </button>

                </div>

            </form>

            <!-- Security Note -->
            <div class="mt-7 rounded-xl border border-slate-100 bg-slate-50 p-4">

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

                    <p class="text-xs leading-relaxed text-slate-500">
                        For your security, choose a strong password that
                        you haven't used before. Never share your password
                        with anyone.
                    </p>

                </div>

            </div>

        </div>


    <!-- Alpine.js Component -->
    <script>
        document.addEventListener('alpine:init', () => {

            Alpine.data('resetPasswordForm', () => ({

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

                    const confirmation = document.getElementById(
                        'password_confirmation'
                    );

                    // Check password matching.
                    if (!this.passwordsMatch) {

                        event.preventDefault();

                        confirmation.setCustomValidity(
                            'Passwords do not match.'
                        );

                        confirmation.reportValidity();
                        confirmation.focus();

                        return;
                    }

                    // Clear custom validation.
                    confirmation.setCustomValidity('');

                    // Respect native HTML5 validation.
                    if (!event.target.checkValidity()) {

                        event.preventDefault();
                        event.target.reportValidity();

                        return;
                    }

                    // Allow Laravel form submission.
                    this.loading = true;

                },

                clearConfirmationError() {

                    const confirmation = document.getElementById(
                        'password_confirmation'
                    );

                    if (confirmation) {
                        confirmation.setCustomValidity('');
                    }

                },

                init() {

                    // Clear mismatch errors whenever either
                    // password field changes.
                    this.$watch('password', () => {
                        this.clearConfirmationError();
                    });

                    this.$watch('passwordConfirmation', () => {
                        this.clearConfirmationError();
                    });

                    // Restore button when returning to this page
                    // using the browser back-forward cache.
                    window.addEventListener('pageshow', () => {
                        this.loading = false;
                    });

                }

            }));

        });
    </script>

</x-authLayout>