@auth
<div class="modal fade" id="add{{ $guideline_id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-red-900">
                <h1 class="modal-title fs-5 text-center text-white">{{ config('app.name') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('Caguide', $guideline_id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="guide_description" class="flex items-center justify-center">Guide Description</label>
                        <input type="text" name="guide_description" class="form-control" autocomplete="off" placeholder="Enter Guide Description">
                    </div>
                    <div class="mb-3">
                        <label for="guide_content" class="flex items-center justify-center">Guide Content</label>
                        <textarea name="guide_content" class="form-control" autocomplete="off" placeholder="Enter Guide Content" rows="5"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="bg-slate-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="bg-red-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200">Publish Guide</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endauth