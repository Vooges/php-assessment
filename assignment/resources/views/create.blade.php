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
            <h2 class="text-2xl font-bold">Verstuur een bericht</h2>
            <p class="mt-2 text-lg text-gray-600">Er gaat niets boven de veiligheid van de data waarmee we werken. Op
                deze pagina kun je een versleuteld bericht sturen. Zo kun je veilig wachtwoorden, code of andere
                berichten delen.</p>
            <div class="mt-8">
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
                    <form action="/send" method="POST">
                        @csrf
                        <div class="flex">
                            <div class="grow">
                                <label class="block">
                                    <span class="text-gray-700">Selecteer een collega</span>
                                    <select class="block w-full mt-1" name="recipient_id">
                                        <option value="" selected>Kies een collega</option>
                                        @foreach ($colleagues as $colleague)
                                            <option value="{{ $colleague->id }}">{{ $colleague->name }}</option>
                                        @endforeach
                                    </select>
                                </label>
                            </div>
                            <div class="flex grow items-center justify-center">
                                <p>Of</p>
                            </div>
                            <div class="grow">
                                <p>Voer handmatig de contactgegevens in:</p>
                                <label class="block">
                                    <span class="text-gray-700">Naam</span>
                                    <input class="block w-full mt-1" name="name" type="text" placeholder="Naam"/>
                                </label>
                                <label class="block">
                                    <span class="text-gray-700">Emailadres</span>
                                    <input class="block w-full mt-1" name="email_address" type="email" placeholder="emailadres"/>
                                </label>
                            </div>
                        </div
                        <label class="block">
                            <span class="text-gray-700">Bericht</span>
                            <textarea class="mt-1 block w-full" rows="5" placeholder="Plaats hier je bericht*" name="contents"></textarea>
                        </label>
                        <label class="flex gap-1">
                            <span class="text-gray-700">(Optioneel) Verwijder automatisch na </span>
                            <input class="block max-w-20 mt-1" name="expire_in_hours" type="number" placeholder="1"/>
                            <span class="text-gray-700"> uur</span>
                        </label>
                        <label class="block grow">
                            <input type="checkbox" name="delete_after_read" value="1"/>
                            <span>Verwijder na lezen</span>
                        </label>
                        <button class="mt-4 w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Versleutel bericht
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
