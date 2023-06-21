@if (auth()->check())
    <div class="modal fade" id="createGuideModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-red-700">
                    <h1 class="modal-title fs-5 text-center text-white">{{ config('app.name') }}</h1>
                </div>
                <div class="modal-body">
                    <form id="createGuideForm" name="createGuideForm">
                        @csrf
                        <input type="hidden" name="create_guide_id">
                        <div class="mb-3">
                            <label for="label" class="flex items-center justify-center">Guide
                                Description</label>
                            <input type="text" name="label" class="form-control" autocomplete="off"
                                placeholder="Enter Guide Description">
                            <span class="text-danger error-text label_error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="content" class="flex items-center justify-center">Guide Content</label>
                            <textarea name="content" class="form-control" autocomplete="off" placeholder="Enter Guide Content" rows="5"></textarea>
                            <span class="text-danger error-text content_error"></span>
                        </div>
                        <div class="modal-footer">
                            <button type="button"
                                class="bg-slate-700 text-white p-2 rounded drop-shadow-lg hover:bg-slate-800"
                                data-bs-dismiss="modal">Close</button>
                            <button id="submitGuideBtn"
                                class="bg-red-600 text-white p-2 rounded drop-shadow-lg hover:bg-red-700">Post
                                Guide</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
