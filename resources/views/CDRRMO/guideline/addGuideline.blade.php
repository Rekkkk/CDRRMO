@auth
<div class="modal fade" id="createGuidelineModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-red-900">
                <h1 class="modal-title fs-5 text-center text-white">{{ config('app.name') }}</h1>
            </div>
            <div class="modal-body">
                <form id="createGuidelineForm" name="createGuidelineForm">
                    @csrf
                    <input type="hidden" name="create_guideline_id" id="create_guideline_id">
                    <div class="mb-3">
                        <label for="guideline_description" class="flex items-center justify-center">Guideline Description</label>
                        <input type="text" name="guideline_description" class="form-control" autocomplete="off" placeholder="Enter Guideline">
                        <span class="text-danger error-text guideline_description_error"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="bg-slate-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200" data-bs-dismiss="modal">Close</button>
                        <button id="submitGuidelineBtn" class="bg-red-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200">Publish Guideline</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endauth