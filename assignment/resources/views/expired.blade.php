<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
</head>
<body>
<div class="antialiased text-gray-900 px-6">
    <div class="max-w-xl mx-auto py-12 divide-y md:max-w-4xl">
        <div class="py-8">
            <h1 class="text-4xl font-bold">{{ config('app.name') }}</h1>
            <div class="mt-4 flex space-x-4">
                <a class="text-lg underline" href="https://github.com/tailwindlabs/tailwindcss-forms">Tailwind Forms
                    Documentation</a>
            </div>
        </div>
        <div class="py-12">
            <h2 class="text-2xl font-bold">Bericht verlopen</h2>
            <p class="mt-2 text-lg text-gray-600">Vraag de verzender om het bericht opnieuw te versturen</p>
        </div>
    </div>
</div>
</body>
</html>