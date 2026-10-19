<x-authLayout>

    <!-- Login Card -->
    <div
        class="w-full max-w-[440px] rounded-2xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-200/60 sm:p-9"
        x-data="loginForm({ hasErrors: @js($errors->any()) })"
    >

        <!-- Card Heading -->
        <div class="mb-8">

            <h2 class="text-2xl font-bold tracking-tight text-indigo-950">
                Welcome back
            </h2>

            <p class="mt-2 text-sm leading-relaxed text-slate-500">
                Sign in to manage your support tickets and stay connected with your university.
            </p>

        </div>

        <!-- Session Status -->
        @if (session('status'))

            <div
                role="status"
                class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700"
            >

                <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7"/>
                </svg>

                <span>{{ session('status') }}</span>

            </div>

        @endif

        <!-- General Error Banner -->
        <div
            x-cloak
            x-show="hasErrors"
            x-transition.opacity.duration.200ms
            role="alert"
            aria-live="assertive"
            class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4"
        >

            <div class="flex items-start gap-3">

                <svg
                    class="mt-0.5 h-5 w-5 shrink-0 text-red-500"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 9v4m0 4h.01M10.29 3.86 1.82 18.14A2 2 0 0 0 3.54 21h16.92a2 2 0 0 0 1.72-2.86L13.71 3.86a2 2 0 0 0-3.42 0Z"
                    />
                </svg>

                <div>
                    <h3 class="text-sm font-semibold text-red-800">
                        Unable to sign in
                    </h3>

                    <p class="mt-1 text-xs leading-relaxed text-red-600">
                        Please check your credentials and try again.
                    </p>
                </div>

            </div>

        </div>

        <!-- Login Form -->
        <form
            method="POST"
            action="{{ route('login') }}"
            x-ref="form"
            x-on:submit="submit($event)"
            x-on:input="resetState()"
            class="space-y-5"
        >

            @csrf

            <!-- Email -->
            <div>

                <label
                    for="email"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    University Email
                </label>

                <div class="relative">

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
                        placeholder="youremail@university.ac.rw"
                        autocomplete="username"
                        required
                        autofocus
                        aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                        @error('email') aria-describedby="email-error" @enderror
                        class="block w-full rounded-xl border bg-white py-3.5 pl-12 pr-4 text-sm text-slate-900 outline-none transition duration-200 placeholder:text-slate-400 focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10
                        {{ $errors->has('email')
                            ? 'border-red-300'
                            : 'border-slate-200 hover:border-slate-300' }}"
                    >

                </div>

                @error('email')
                    <p id="email-error" class="mt-2 text-xs font-medium text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <!-- Password -->
            <div>

                <div class="mb-2 flex items-center justify-between gap-3">

                    <label
                        for="password"
                        class="text-sm font-semibold text-slate-700"
                    >
                        Password
                    </label>

                    @if (Route::has('password.request'))

                        <a
                            href="{{ route('password.request') }}"
                            class="text-xs font-semibold text-sky-600 transition hover:text-sky-700 hover:underline focus-visible:rounded focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600"
                        >
                            Forgot password?
                        </a>

                    @endif

                </div>

                <div class="relative">

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
                                d="M5 11V7a7 7 0 0 1 14 0v4M5 11h14a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-6a2 2 0 0 1 2-2Z"
                            />
                        </svg>

                    </div>

                    <input
                        id="password"
                        name="password"
                        type="password"
                        x-bind:type="showPassword ? 'text' : 'password'"
                        placeholder="••••••••"
                        autocomplete="current-password"
                        required
                        aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                        @error('password') aria-describedby="password-error" @enderror
                        class="block w-full rounded-xl border bg-white py-3.5 pl-12 pr-12 text-sm text-slate-900 outline-none transition duration-200 placeholder:text-slate-400 focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10
                        {{ $errors->has('password')
                            ? 'border-red-300'
                            : 'border-slate-200 hover:border-slate-300' }}"
                    >

                    <!-- Password Visibility -->
                    <button
                        type="button"
                        x-on:click="showPassword = !showPassword"
                        x-bind:aria-label="showPassword ? 'Hide password' : 'Show password'"
                        x-bind:aria-pressed="showPassword.toString()"
                        class="absolute inset-y-0 right-0 flex items-center rounded-r-xl px-4 text-slate-400 transition hover:text-sky-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-sky-500"
                    >

                        <!-- Eye -->
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

                        <!-- Eye Off -->
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

                @error('password')
                    <p id="password-error" class="mt-2 text-xs font-medium text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <!-- Remember Me -->
            <div class="flex items-center">

                <label class="inline-flex cursor-pointer items-center gap-3">

                    <input
                        type="checkbox"
                        name="remember"
                        id="remember"
                        value="1"
                        {{ old('remember') ? 'checked' : '' }}
                        class="h-4 w-4 cursor-pointer rounded border-slate-300 text-sky-600 focus:ring-2 focus:ring-sky-500/30"
                    >

                    <span class="text-sm font-medium text-slate-600">
                        Remember me
                    </span>

                </label>

            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                x-bind:disabled="loading || hasErrors"
                x-bind:aria-busy="loading.toString()"
                class="group flex w-full items-center justify-center gap-3 rounded-xl bg-sky-600 px-5 py-3.5 text-sm font-semibold text-white shadow-md shadow-sky-600/20 transition-all duration-200 hover:-translate-y-0.5 hover:bg-sky-700 hover:shadow-lg hover:shadow-sky-600/25 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600 active:translate-y-0 disabled:cursor-not-allowed disabled:opacity-60 disabled:hover:translate-y-0 disabled:hover:shadow-none"
            >

                <!-- Normal State -->
                <span
                    x-show="!loading"
                    class="flex items-center justify-center gap-2"
                >

                    <span>Sign In</span>

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

                    <span>Signing in...</span>

                </span>

            </button>

        </form>

        <!-- Registration -->
        @if (Route::has('register'))

            <div class="mt-8 border-t border-slate-100 pt-7 text-center">

                <p class="text-sm text-slate-500">
                    Don't have an account?

                    <a
                        href="{{ route('register') }}"
                        class="ml-1 font-bold text-sky-600 transition hover:text-sky-700 hover:underline focus-visible:rounded focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600"
                    >
                        Create account
                    </a>
                </p>

            </div>

        @endif

    </div>

     <!-- Alpine Login Logic -->
    <script>
        document.addEventListener('alpine:init', () => {

            Alpine.data('loginForm', (config = {}) => ({

                loading: false,
                hasErrors: Boolean(config.hasErrors),
                showPassword: false,

                submit(event) {

                    // Prevent duplicate submissions.
                    if (this.loading || this.hasErrors) {
                        event.preventDefault();
                        return;
                    }

                    // Respect native HTML5 form validation.
                    if (!event.target.checkValidity()) {
                        event.preventDefault();
                        event.target.reportValidity();
                        return;
                    }

                    // Allow the browser to submit the form normally.
                    // Laravel handles authentication and redirects.
                    this.loading = true;

                },

                resetState() {

                    // Any change to the credentials clears the
                    // general error and restores the submit button.
                    this.loading = false;
                    this.hasErrors = false;

                }

            }));

        });
    </script>

</x-authLayout>
