<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="shortcut icon" href="{{ URL('assets/img/CDRRMO-LOGO.png') }}" type="image/png">
    <title>{{ config('app.name')}}</title>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body style="background: #0E1624;">
    <header class="max-w-lg mx-auto">
        <a href="/">
            <h1 class="text-4xl font-bold text-white text-center pt-12">{{ config('app.name')}}</h1>
        </a>
    </header>
    <x-messages />
    <main class="max-w-lg mx-auto p-8 my-10 rounded-lg shadow-2xl bg-slate-800">
        <section>
            <h3 class="font-bold text-2xl text-center text-white">Welcome to E-LIGTAS</h3>
        </section>
        <section class="mt-10 flex flex-col">
            <form action="/resident/dashboard" method="POST" class="flex items-center whitespace-nowrap cursor-pointer">
                @method('GET')
                @csrf
                <button type="submit" class="btn w-full mb-3 bg-red-800 text-white hover:bg-red-900">
                    Continue as Resident
                </button>
            </form>

            <button type="button" class="btn bg-green-800 text-white hover:bg-green-900" data-bs-toggle="modal" data-bs-target="#adminMode">
                Continue to Admin Panel
            </button>
            
            <div class="modal fade" id="adminMode" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 text-center">{{ config('app.name') }}</h1>
                        </div>
                        <form action="/cdrrmo" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-6 pt-3 rounded bg-gray-200">
                                    <label for="id" class="block text-center text-gray-700 text-sm font-bold mb-2 ml-3">Admin Number</label>
                                    <input type="text" name="id" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-400 px-3" autocomplete="off">
                                </div>
                                <div class="mb-6 pt-3 rounded bg-gray-200">
                                    <label for="password" class="block text-center text-gray-700 text-sm font-bold mb-2 ml-3">Admin Password</label>
                                    <input type="password" name="password" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-400 px-3" autocomplete="off">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="bg-red-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="bg-green-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200" >Authenticate</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <x-errorMessage />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>