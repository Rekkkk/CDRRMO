<div class="modal fade" id="editAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-red-700">
                <h1 class="modal-title fs-5 text-center text-white">{{ config('app.name') }}</h1>
            </div>
            <div class="modal-body">
                <form id="accountForm">
                    @csrf
                    <input type="text" name="accountId" id="accountId" hidden>
                    @if (Auth::user()->position == 'President')
                        <div class="mb-3">
                            <label for="user_role" class="flex items-center justify-center">User Role</label>
                            <input type="text" name="user_role" class="form-control" autocomplete="off"
                                id="user_role" placeholder="Enter User Role">
                            <span class="text-danger error-text user_role_error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="position" class="flex items-center justify-center">Position</label>
                            <input type="text" name="position" class="form-control" id="position"
                                autocomplete="off" placeholder="Enter Position">
                            <span class="text-danger error-text position_error"></span>
                        </div>
                    @else
                        <input type="hidden" name="user_role" class="form-control" id="user_role">
                        <input type="hidden" name="position" class="form-control" id="position">
                    @endif
                    <div class="mb-3">
                        <label for="email" class="flex items-center justify-center">Email Address</label>
                        <input type="text" name="email" class="form-control" autocomplete="off" id="email"
                            placeholder="Enter Email Address">
                        <span class="text-danger error-text email_error"></span>
                    </div>

                    <div class="modal-footer">
                        <button type="button"
                            class="bg-slate-600 text-white p-2 rounded drop-shadow-lg hover:bg-slate-700"
                            data-bs-dismiss="modal">Close</button>
                        <button id="saveProfileDetails"
                            class="bg-red-700 text-white p-2 rounded drop-shadow-lg hover:bg-red-800">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
