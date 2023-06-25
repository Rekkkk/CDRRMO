@if (auth()->user()->user_role == 'CDRRMO')
    <div class="modal fade" id="editEvacuationCenter" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editEvacuationForm">
                    <input type="text" name="evacuationCenterId" id="evacuationCenterId" hidden>
                    <div class="modal-header bg-red-900">
                        <h1 class="modal-title fs-5 text-center text-white">{{ config('app.name') }}</h1>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="flex items-center justify-center">Evacuation
                                Name</label>
                            <input type="text" name="name" id="name" class="form-control" autocomplete="off">
                            <span class="text-danger error-text name_error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="barangay_name" class="flex items-center justify-center">
                                Barangay Name</label>
                            <input type="text" name="barangay_name" id="barangay_name" class="form-control"
                                autocomplete="off">
                            <span class="text-danger error-text barangay_name_error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="latitude" class="flex items-center justify-center">Evacuation
                                Latitude</label>
                            <input type="text" name="latitude" id="latitude" class="form-control"
                                autocomplete="off">
                            <span class="text-danger error-text latitude_error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="longitude" class="flex items-center justify-center">Evacuation
                                Logitude</label>
                            <input type="text" name="longitude" id="longitude" class="form-control"
                                autocomplete="off">
                            <span class="text-danger error-text longitude_error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="flex items-center justify-center">Status</label>
                            <input type="text" name="status" id="status" class="form-control" autocomplete="off">
                            <span class="text-danger error-text status_error"></span>
                        </div>
                        <div class="modal-footer text-white">
                            <button type="button" class="bg-slate-700 p-2 rounded shadow-lg hover:shadow-xl"
                                data-bs-dismiss="modal">Close</button>
                            <button type="button" id="editEvacuationCenterBtn"
                                class="bg-red-700 p-2 rounded shadow-lg hover:shadow-xl">Update
                                Evacuation Center</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
