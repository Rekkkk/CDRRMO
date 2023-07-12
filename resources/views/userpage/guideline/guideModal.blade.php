<div class="modal fade" id="guideModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-green-600">
                <h1 class="modal-title fs-5 text-center text-white">Create Guide Form</h1>
            </div>
            <div class="modal-body">
                <form id="guideForm">
                    <input type="text" id="operation" hidden>
                    @csrf
                    <div class="mb-3">
                        <label for="label" class="flex items-center justify-center">Guide
                            Description</label>
                        <input type="text" name="label" class="form-control" autocomplete="off"
                            placeholder="Enter Guide Description" id="label">
                    </div>
                    <div class="mb-3">
                        <label for="content" class="flex items-center justify-center">Guide Content</label>
                        <textarea name="content" class="form-control" autocomplete="off" placeholder="Enter Guide Content" rows="5" id="content"></textarea>
                    </div>
                    <div class="modal-footer text-white">
                        <button id="submitGuideBtn" class="btn-submit p-2">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
