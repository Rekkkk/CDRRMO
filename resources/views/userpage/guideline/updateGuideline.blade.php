<div class="modal fade" id="edit{{ $guidelineItem->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-yellow-500">
                <h1 class="modal-title fs-5 text-center text-white">Update Guideline Form</h1>
            </div>
            <div class="modal-body">
                <form action="{{ route('guideline.update', $guidelineItem->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="mb-3">
                        <label for="type" class="flex items-center justify-center">Guideline
                            Desctription</label>
                        <input type="text" name="type" value="{{ $guidelineItem->type }}" class="form-control"
                            autocomplete="off">
                    </div>
                    <div class="modal-footer text-white">
                        <button type="submit" class="btn-edit bg-yellow-500 p-2">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
