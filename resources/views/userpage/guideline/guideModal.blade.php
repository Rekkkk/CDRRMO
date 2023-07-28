<div class="modal fade" id="guideModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header justify-center bg-green-600">
                <h1 class="modal-title fs-5 text-white font-bold">Create Guide Form</h1>
            </div>
            <div class="modal-body">
                <form id="guideForm">
                    @csrf
                    <div class="bg-slate-50 pt-3 pb-2 rounded">
                        <input type="text" id="guide_operation" hidden>
                        <div class="flex-auto">
                            <div class="flex flex-wrap">
                                <input type="text" id="guideline_operation" hidden>
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
                                <div class="w-full px-4 pt-2 pb-3">
                                    <button id="submitGuideBtn" class="btn-submit p-2 float-right">Create</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
