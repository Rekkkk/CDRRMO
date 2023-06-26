<div class="modal fade" id="edit{{ $guide->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-red-900">
                <h1 class="modal-title fs-5 text-center text-white">Guide Form</h1>
            </div>
            <div class="modal-body">
                <form action="{{ route('update.guide.cdrrmo', $guide->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <input type="text" name="guideline_id" value="{{ $guide->guideline_id }}" hidden>
                    <div class="mb-3">
                        <label for="label" class="flex items-center justify-center">Guide
                            Desctription</label>
                        <input type="text" name="label" value="{{ $guide->label }}" class="form-control"
                            autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="content" class="flex items-center justify-center">Guide Content</label>
                        <textarea name="content" class="form-control" autocomplete="off" placeholder="Enter Guide Content" rows="5">{{ $guide->content }}</textarea>
                    </div>
                    <div class="modal-footer text-white">
                        <button type="button" class="bg-slate-600 p-2 rounded drop-shadow-lg hover:bg-slate-700"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit"
                            class="bg-red-700 p-2 rounded drop-shadow-lg hover:bg-red-800">Update
                            Guide</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
