@include('partials.headerHome')
    <main class="max-w-lg mx-auto p-8 my-10 rounded-lg shadow-2xl bg-slate-800">
        <section>
            <h3 class="font-bold text-2xl text-center text-white">Welcome to E-LIGTAS</h3>
        </section>
        <section class="mt-10 flex flex-col">
            <form action="/resident/dashboard" method="POST" class="flex ites-center whitespace-nowrap cursor-pointer">
                @method('GET')
                @csrf
                <button type="submit" class="btn w-full mb-3 bg-cyan-600 text-white hover:bg-cyan-900">
                    Continue as Guess
                </button>
            </form>

            <button type="button" class="btn bg-green-800 text-white hover:bg-green-900" data-bs-toggle="modal" data-bs-target="#adminMode">
                Continue as Admin
            </button>
            
            <div class="modal fade" id="adminMode" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">{{ config('app.name')}}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/cdrrmo" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-6 pt-3 rounded bg-gray-200">
                                    <label for="id" class="block text-gray-700 text-sm font-bold mb-2 ml-3">Id</label>
                                    <input type="number" name="id" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-400 px-3">
                                </div>
                                <div class="mb-6 pt-3 rounded bg-gray-200">
                                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2 ml-3">Password</label>
                                    <input type="password" name="password" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-400 px-3">
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