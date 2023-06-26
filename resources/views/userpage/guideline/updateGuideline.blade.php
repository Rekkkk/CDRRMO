<div class="modal fade" id="edit{{ $guidelineItem->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-red-700">
                <h1 class="modal-title fs-5 text-center text-white">Guide Form</h1>
            </div>
            <div class="modal-body">
                <form action="{{ route('update.guideline.cdrrmo', $guidelineItem->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="mb-3">
                        <label for="type" class="flex items-center justify-center">Guideline
                            Desctription</label>
                        <input type="text" name="type" value="{{ $guidelineItem->type }}" class="form-control"
                            autocomplete="off">
                    </div>
                    <div class="modal-footer text-white">
                        <button type="button" class="bg-slate-600 p-2 rounded drop-shadow-lg hover:bg-slate-700"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit"
                            class="bg-red-700 p-2 rounded drop-shadow-lg hover:bg-red-800">Update
                            Guideline</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
