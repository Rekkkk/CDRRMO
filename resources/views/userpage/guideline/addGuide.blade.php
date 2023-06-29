<div class="modal fade" id="createGuideModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-green-600">
                <h1 class="modal-title fs-5 text-center text-white">Create Guide Form</h1>
            </div>
            <div class="modal-body">
                <form id="createGuideForm">
                    @csrf
                    <input type="text" name="create_guide_id" hidden>
                    <div class="mb-3">
                        <label for="label" class="flex items-center justify-center">Guide
                            Description</label>
                        <input type="text" name="label" class="form-control" autocomplete="off"
                            placeholder="Enter Guide Description">
                    </div>
                    <div class="mb-3">
                        <label for="content" class="flex items-center justify-center">Guide Content</label>
                        <textarea name="content" class="form-control" autocomplete="off" placeholder="Enter Guide Content" rows="5"></textarea>
                    </div>
                    <div class="modal-footer text-white">
                        <button id="submitGuideBtn"
                            class="btn-submit p-2">Post
                            Guide</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
