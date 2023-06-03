@if(Auth::check() && Auth::user()->user_role == 'CDRRMO')
    <div class="modal fade" id="edit{{ $guide->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-red-900">
                    <h1 class="modal-title fs-5 text-center text-white">{{ config('app.name') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('update.guide.cdrrmo', $guide->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <input type="text" name="guideline_id" value="{{ $guide->guideline_id }}" hidden>
                        <div class="mb-3">
                            <label for="label" class="flex items-center justify-center">Guide
                                Desctription</label>
                            <input type="text" name="label" value="{{ $guide->label }}"
                                class="form-control" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="content" class="flex items-center justify-center">Guide Content</label>
                            <textarea name="content" class="form-control" autocomplete="off" placeholder="Enter Guide Content" rows="5">{{ $guide->content }}</textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button"
                                class="bg-slate-700 text-white p-2 rounded shadow-lg hover:shadow-xl"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit"
                                class="bg-red-700 text-white p-2 rounded shadow-lg hover:shadow-xl">Update
                                Guide</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
