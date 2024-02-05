<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        @vite(['resources/css/app.css'])

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet" />

    </head>

    <body class="antialiased font-sans">
        <div
            class="relative flex items-top justify-center min-h-screen bg-teal-100 dark:bg-teal-900 sm:items-center sm:pt-0">
            <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
                <div class="flex items-center pt-8 sm:justify-start sm:pt-0">
                    <div class="px-4 text-lg text-gray-500 border-r border-gray-400 tracking-wider">
                        @yield('code')
                    </div>

                    <div class="ml-4 text-lg text-gray-500 uppercase tracking-wider">
                        @yield('message')
                    </div>


                </div>
                <div class="flex items-center justify-center mt-4">
                    <a href="{{ route('welcome') }}" class="ml-4 text-sm text-gray-700 underline">Home</a>
                </div>
            </div>
        </div>
    </body>

</html>
