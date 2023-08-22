<div class="modal fade" id="createAccidentReportModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-label-container bg-success">
                <h1 class="modal-label">Incident Report</h1>
            </div>
            <div class="modal-body">
                <form id="reportForm" enctype="multipart/form-data">
                    @csrf
                    <div class="form-content">
                        <div class="field-container">
                            <label>Report Description</label>
                            <textarea type="text" id="description" name="description" class="form-control" rows="5"
                                placeholder="Enter Incident Description" autocomplete="off"></textarea>
                        </div>
                        <div class="field-container">
                            <label>Report Location</label>
                            <input type="text" id="location" name="location" class="form-control"
                                placeholder="Enter Incident Location" autocomplete="off">
                        </div>
                        <div class="field-container">
                            <label>Report Photo</label>
                            <input type="file" id="photo" name="photo" class="form-control form-control-lg"
                                placeholder="Enter Incident Location" accept=".jpeg">
                        </div>
                        <div class="form-button-container">
                            <button id="reportIncidentBtn" class="btn-submit">Report</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
