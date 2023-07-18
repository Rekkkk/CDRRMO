<div class="modal fade" id="disasterModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-green-600">
                <h1 class="modal-title fs-5 text-white">Create Disaster Form</h1>
            </div>
            <div class="modal-body">
                <form id="disasterForm">
                    <input type="text" id="operation" hidden>
                    @csrf
                    <div class="mb-3">
                        <label for="type" class="flex items-center justify-center">Disaster Name</label>
                        <input type="text" name="name" class="form-control" autocomplete="off"
                            placeholder="Enter Disaster Name" id="disasterName">
                    </div>
                    <div class="mb-3">
                        <label for="type" class="flex items-center justify-center">Location</label>
                        <input type="text" name="location" class="form-control" autocomplete="off"
                            placeholder="Enter Location" id="location">
                    </div>
                    <div class="modal-footer">
                        <button id="submitDisasterBtn" class="btn-submit p-2">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
