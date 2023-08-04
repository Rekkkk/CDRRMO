<div class="modal fade" id="guidelineModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-label-container">
                <h1 class="modal-label"></h1>
            </div>
            <div class="modal-body">
                <form id="guidelineForm">
                    @csrf
                    <div class="form-content">
                        <input type="text" id="guideline_operation" hidden>
                        <div class="field-container">
                            <label>Guideline Type</label>
                            <input type="text" name="type" class="form-control" autocomplete="off"
                                placeholder="Enter Guideline Type" id="guidelineType">
                        </div>
                        <div class="form-button-container">
                            <button id="submitGuidelineBtn" class="btn-submit">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
