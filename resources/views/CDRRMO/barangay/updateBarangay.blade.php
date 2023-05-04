@auth
    <div class="modal fade" id="edit{{ $barangayList->barangay_id }}" tabindex="-1" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-red-900">
                    <h1 class="modal-title fs-5 text-center text-white" id="exampleModalLabel">{{ config('app.name') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('Cupdatebarangay', $barangayList->barangay_id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="mb-3">
                            <label for="barangay_name" class="flex items-center justify-center">Barangay Name</label>
                            <input type="text" name="barangay_name" value="{{ $barangayList->barangay_name }}"
                                class="form-control" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="barangay_location" class="flex items-center justify-center">Barangay
                                Location</label>
                            <input type="text" name="barangay_location" value="{{ $barangayList->barangay_location }}"
                                class="form-control" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="barangay_contact" class="flex items-center justify-center">Barangay Contact
                                Number</label>
                            <input type="text" name="barangay_contact"
                                value="{{ $barangayList->barangay_contact_number }}" class="form-control"
                                autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="barangay_email" class="flex items-center justify-center">Barangay Email
                                Address</label>
                            <input type="text" name="barangay_email" value="{{ $barangayList->barangay_email_address }}"
                                class="form-control" autocomplete="off">
                        </div>
                        <div class="modal-footer">
                            <button type="button"
                                class="bg-slate-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit"
                                class="bg-red-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200">Update
                                Barangay</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endauth
