@if (Auth::check() && Auth::user()->user_role == 'CDRRMO')
    <div class="modal fade" id="edit{{ $guidelineItem->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-red-900">
                    <h1 class="modal-title fs-5 text-center text-white">{{ config('app.name') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('update.guideline.cdrrmo', $guidelineItem->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="mb-3">
                            <label for="type" class="flex items-center justify-center">Guideline
                                Desctription</label>
                            <input type="text" name="type"
                                value="{{ $guidelineItem->type }}" class="form-control"
                                autocomplete="off">
                        </div>
                        <div class="modal-footer">
                            <button type="button"
                                class="bg-slate-700 text-white p-2 rounded shadow-lg hover:shadow-xl"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit"
                                class="bg-red-700 text-white p-2 rounded shadow-lg hover:shadow-xl">Update
                                Guideline</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif