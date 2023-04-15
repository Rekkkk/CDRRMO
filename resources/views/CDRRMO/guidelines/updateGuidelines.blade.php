@auth
<div class="modal fade" id="edit{{ $guidelinesItem->guidelines_id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-red-900">
                <h1 class="modal-title fs-5 text-center text-white">{{ config('app.name') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('Cupdateguidelines', $guidelinesItem->guidelines_id) }}" method="GET">
                    @csrf
                    <div class="mb-3">
                        <label for="guideline_description" class="flex items-center justify-center">Guideline Desctription</label>
                        <input type="text" name="guideline_description" value="{{ $guidelinesItem->guidelines_description }}" class="form-control" autocomplete="off">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="bg-slate-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="bg-red-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200">Update Guideline</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endauth