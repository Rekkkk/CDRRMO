<div class="modal fade" id="guidelineModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-green-600">
                <h1 class="modal-title fs-5 text-white">Create Guideline Form</h1>
            </div>
            <div class="modal-body">
                <form id="guidelineForm" name="guidelineForm">
                    @csrf
                    <div class="mb-3">
                        <label for="type" class="flex items-center justify-center">Guideline
                            Type</label>
                        <input type="text" name="type" class="form-control" autocomplete="off"
                            placeholder="Enter Guideline Type">
                        <span class="text-danger error-text type_error"></span>
                    </div>
                    <div class="modal-footer">
                        <button id="submitGuidelineBtn" class="btn-submit p-2">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
