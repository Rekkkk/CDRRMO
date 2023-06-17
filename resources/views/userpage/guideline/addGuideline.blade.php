@if (Auth::check() && Auth::user()->user_role == 'CDRRMO')
    <div class="modal fade" id="createGuidelineModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-red-700">
                    <h1 class="modal-title fs-5 text-center text-white">{{ config('app.name') }}</h1>
                </div>
                <div class="modal-body">
                    <form id="createGuidelineForm" name="createGuidelineForm">
                        @csrf
                        <input type="hidden" name="create_guideline_id" id="create_guideline_id">
                        <div class="mb-3">
                            <label for="type" class="flex items-center justify-center">Guideline
                                Description</label>
                            <input type="text" name="type" class="form-control" autocomplete="off"
                                placeholder="Enter Guideline">
                            <span class="text-danger error-text type_error"></span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="bg-slate-600 text-white p-2 rounded shadow-lg hover:bg-slate-700"
                                data-bs-dismiss="modal">Close</button>
                            <button id="submitGuidelineBtn"
                                class="bg-red-600 text-white p-2 rounded shadow-lg hover:bg-red-700">Publish
                                Guideline</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
