<div class="modal fade" id="disasterModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-label-container">
                <h1 class="modal-label"></h1>
            </div>
            <div class="modal-body">
                <form id="disasterForm">
                    @csrf
                    <div class="form-content">
                        <input type="text" id="operation" hidden>
                        <div class="field-container">
                            <label>Disaster Name</label>
                            <input type="text" name="name" class="form-control" autocomplete="off"
                                placeholder="Enter Disaster Name" id="disasterName">
                        </div>
                        <div class="form-button-container">
                            <button id="submitDisasterBtn" class="btn-submit">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
