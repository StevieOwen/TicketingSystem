
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sign In | University Ticketing System</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <!-- Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-slate-50 antialiased text-slate-700">

    <main class="flex min-h-screen flex-col items-center justify-center px-4 py-12 sm:px-6">

        <!-- Branding -->
        <div class="mb-8 text-center">

            <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-2xl bg-indigo-950 shadow-lg shadow-indigo-950/15">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-8 w-8 text-white"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.7"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 3 2 8l10 5 10-5-10-5ZM5 10v6c0 2.5 3.1 4.5 7 4.5s7-2 7-4.5v-6M22 8v7"
                    />
                </svg>

            </div>

            <h1 class="text-2xl font-extrabold tracking-tight text-indigo-950 sm:text-3xl">
                University Ticketing
            </h1>

            <p class="mt-2 text-sm text-slate-500">
                Your campus support, simplified.
            </p>

        </div>

        {{$slot}}

         <!-- Footer -->
        <div class="mt-8 max-w-md text-center">

            <p class="text-xs leading-relaxed text-slate-400">
                Secure access to your university support portal.
            </p>

            <p class="mt-3 text-xs text-slate-400">
                &copy; {{ date('Y') }} University Ticketing System.
                All rights reserved.
            </p>

        </div>

    </main>

   

</body>
</html>