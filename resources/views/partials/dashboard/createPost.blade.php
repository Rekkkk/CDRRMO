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
                <form action="{{ route('CCreateAnnouncement') }}" method="POST">
                    @method('GET')
                    @csrf
                    <div class="modal-body">
                        <div class="mb-6 pt-3">
                            <label for="post-title" class="pb-2">Caption</label>
                            <input type="text" name="announcement_description" class="form-control" id="post-title" placeholder="Caption Here..."><br>
                        </div>

                        <div class="mb-6">
                            <label for="id" class="pb-2">Announcement</label>
                            <textarea class="form-control" name="announcement_content" rows="4" autocomplete="off" placeholder="Content Here..."></textarea>
                        </div>

                        <div class="mb-6">
                            <i class="bi bi-images text-lime-600"></i>
                            <label for="post-image">Image/Video: </label>
                            <input type="file" id="post-image" name="announcement_file"><br>
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