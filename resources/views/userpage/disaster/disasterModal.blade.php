<div class="modal fade" id="disasterModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-green-600">
                <h1 class="modal-title fs-5 text-white">Create Disaster Form</h1>
            </div>
            <div class="modal-body">
                <form id="disasterForm">
                    @csrf
                    <div class="bg-slate-50 pt-3 pb-2 rounded">
                        <div class="flex-auto">
                            <div class="flex flex-wrap">
                                <input type="text" id="operation" hidden>
                                <div class="field-container">
                                    <label>Disaster Name</label>
                                    <input type="text" name="name" class="form-control" autocomplete="off"
                                        placeholder="Enter Disaster Name" id="disasterName">
                                </div>
                                <div class="field-container">
                                    <label>Location</label>
                                    <input type="text" name="location" class="form-control" autocomplete="off"
                                        placeholder="Enter Location" id="location">
                                </div>
                                <div class="w-full">
                                    <button id="submitDisasterBtn"
                                        class="btn-submit p-2 float-right">Create</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
