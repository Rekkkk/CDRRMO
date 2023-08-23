<div class="modal fade" id="guideModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-label-container">
                <h1 class="modal-label"></h1>
            </div>
            <div class="modal-body">
                <form id="guideForm">
                    @csrf
                    <div class="form-content">
                        <div class="field-container">
                            <label>Guide Description</label>
                            <input type="text" name="label" class="form-control" autocomplete="off"
                                placeholder="Enter Guide Description" id="label">
                        </div>
                        <div class="field-container">
                            <label>Guide Content</label>
                            <textarea name="content" class="form-control" autocomplete="off" placeholder="Enter Guide Content" rows="5"
                                id="content"></textarea>
                        </div>
                        <div class="form-button-container">
                            <button id="submitGuideBtn"></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
