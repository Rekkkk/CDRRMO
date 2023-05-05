@auth
    <div class="modal fade" id="editBarangay" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editBarangayForm">
                    <input type="text" name="barangayId" id="barangayId" hidden>
                    <div class="modal-header bg-red-900">
                        <h1 class="modal-title fs-5 text-center text-white">
                            {{ config('app.name') }}
                        </h1>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="flex items-center justify-center">Barangay
                                Name</label>
                            <input type="text" name="name" id="name" class="form-control" autocomplete="off">
                            <span class="text-danger error-text name_error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="flex items-center justify-center">Barangay
                                Location</label>
                            <input type="text" name="location" id="location" class="form-control" autocomplete="off">
                            <span class="text-danger error-text location_error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="contact" class="flex items-center justify-center">Barangay
                                Contact
                                Number</label>
                            <input type="text" name="contact" id="contact" class="form-control" autocomplete="off">
                            <span class="text-danger error-text contact_error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="flex items-center justify-center">Barangay
                                Email
                                Address</label>
                            <input type="email" name="email" id="email" class="form-control" autocomplete="off">
                            <span class="text-danger error-text email_error"></span>
                        </div>
                        <div class="modal-footer">
                            <button type="button"
                                class="bg-slate-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200"
                                data-bs-dismiss="modal">Close</button>
                            <button type="button" id="editbarangay"
                                class="bg-red-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200">
                                Update Barangay
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endauth
