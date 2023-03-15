@auth
<div class="create-post my-2 rounded">
    <button type="button" class="text-emerald-50 rounded bg-slate-800 hover:bg-slate-900 fixed right-0 bottom-0 mx-4 my-4 p-2" data-bs-toggle="modal" data-bs-target="#createPost">
        <i class="bi bi-plus-lg mx-2"></i>
        Create Announcement
    </button>
    <div class="modal fade" id="createPost" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h1 class="modal-title fs-5">New Announcement</h1>
                </div>
                <form action="#" method="POST">
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
                        <button type="submit" class="bg-green-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200" >Post Announcement</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endauth