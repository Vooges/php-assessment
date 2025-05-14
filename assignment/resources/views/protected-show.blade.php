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
            <h2 class="text-2xl font-bold">Bericht vergrendeld</h2>
            <div class="mt-8 max-w-md">
                <div class="grid grid-cols-1 gap-6">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ $decryptedMessageUrl }}" method="POST">
                        @csrf
                        <label class="block">
                            <span class="text-gray-700">Wachtwoord</span>
                            <input type="password" class="mt-1 block w-full" rows="5" placeholder="Wachtwoord*" name="password"/>
                        </label>
                        <button class="mt-4 w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Ontgrendel bericht
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
