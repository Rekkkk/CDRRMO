@if (Auth::user()->user_role == '1')
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
                            <label for="evacuation_name" class="flex items-center justify-center">Evacuation
                                Name</label>
                            <input type="text" name="evacuation_name" id="evacuation_name" class="form-control"
                                autocomplete="off">
                            <span class="text-danger error-text evacuation_name_error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="evacuation_contact" class="flex items-center justify-center">Evacuation
                                Contact</label>
                            <input type="text" name="evacuation_contact" id="evacuation_contact" class="form-control"
                                autocomplete="off">
                            <span class="text-danger error-text evacuation_contact_error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="evacuation_address" class="flex items-center justify-center">Evacuation
                                Address</label>
                            <input type="text" name="evacuation_address" id="evacuation_address" class="form-control"
                                autocomplete="off">
                            <span class="text-danger error-text evacuation_address_error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="barangay_evacuation_id" class="flex items-center justify-center">
                                Barangay_id</label>
                            <input type="text" name="barangay_evacuation_id" id="barangay_evacuation_id"
                                class="form-control" autocomplete="off">
                            <span class="text-danger error-text barangay_evacuation_id_error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="evacuation_latitude" class="flex items-center justify-center">Evacuation
                                Latitude</label>
                            <input type="text" name="evacuation_latitude" id="evacuation_latitude"
                                class="form-control" autocomplete="off">
                            <span class="text-danger error-text evacuation_latitude_error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="evacuation_longitude" class="flex items-center justify-center">Evacuation
                                Logitude</label>
                            <input type="text" name="evacuation_longitude" id="evacuation_longitude"
                                class="form-control" autocomplete="off">
                            <span class="text-danger error-text evacuation_longitude_error"></span>
                        </div>
                        <div class="modal-footer text-white">
                            <button type="button"
                                class="bg-slate-700 p-2 rounded shadow-lg hover:shadow-xl"
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
